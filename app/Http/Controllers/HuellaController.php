<?php

namespace App\Http\Controllers;

use App\Models\Beneficiario;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class HuellaController extends Controller
{
    /**
     * Guardar huella dactilar del beneficiario
     */
    public function guardarHuella(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'beneficiario_id' => 'required|exists:beneficiarios,id',
            'huella_template' => 'required|string|min:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $beneficiario = Beneficiario::findOrFail($request->beneficiario_id);
            
            // Verificar si ya tiene huella registrada
            if ($beneficiario->huella_template) {
                return response()->json([
                    'success' => false,
                    'message' => 'El beneficiario ya tiene una huella registrada'
                ], 409);
            }

            // Guardar la huella
            $beneficiario->huella_template = $request->huella_template;
            $beneficiario->save();

            return response()->json([
                'success' => true,
                'message' => 'Huella dactilar guardada exitosamente',
                'beneficiario' => [
                    'id' => $beneficiario->id,
                    'nombre' => $beneficiario->nombre_completo,
                    'codigo' => $beneficiario->codigo
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar la huella: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar huella dactilar del beneficiario
     */
    public function actualizarHuella(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'beneficiario_id' => 'required|exists:beneficiarios,id',
            'huella_template' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $beneficiario = Beneficiario::findOrFail($request->beneficiario_id);
            
            // Actualizar la huella
            $beneficiario->huella_template = $request->huella_template;
            $beneficiario->save();

            return response()->json([
                'success' => true,
                'message' => 'Huella dactilar actualizada exitosamente',
                'beneficiario' => [
                    'id' => $beneficiario->id,
                    'nombre' => $beneficiario->nombre_completo,
                    'codigo' => $beneficiario->codigo
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la huella: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verificar si el beneficiario tiene huella registrada
     */
    public function verificarHuella(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'beneficiario_id' => 'required|exists:beneficiarios,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $beneficiario = Beneficiario::findOrFail($request->beneficiario_id);
            
            return response()->json([
                'success' => true,
                'tiene_huella' => !empty($beneficiario->huella_template),
                'beneficiario' => [
                    'id' => $beneficiario->id,
                    'nombre' => $beneficiario->nombre_completo,
                    'codigo' => $beneficiario->codigo
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar la huella: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener huella dactilar del beneficiario
     */
    public function obtenerHuella($beneficiarioId): JsonResponse
    {
        try {
            $beneficiario = Beneficiario::findOrFail($beneficiarioId);
            
            if (empty($beneficiario->huella_template)) {
                return response()->json([
                    'success' => false,
                    'message' => 'El beneficiario no tiene huella registrada'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'huella_template' => $beneficiario->huella_template,
                'beneficiario' => [
                    'id' => $beneficiario->id,
                    'nombre' => $beneficiario->nombre_completo,
                    'codigo' => $beneficiario->codigo
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la huella: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Identificar beneficiario únicamente por huella dactilar
     */
    public function identificarPorHuella(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'huella_capturada' => 'required|string|min:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $huellaCapturada = $request->huella_capturada;
            
            Log::info('Iniciando identificación por huella', [
                'longitud_huella_capturada' => strlen($huellaCapturada),
                'timestamp' => now()
            ]);
            
            // Obtener todos los beneficiarios activos que tienen huella registrada
            $beneficiariosConHuella = Beneficiario::activos()
                ->whereNotNull('huella_template')
                ->where('huella_template', '!=', '')
                ->get();

            Log::info('Beneficiarios con huella encontrados', [
                'total_beneficiarios' => $beneficiariosConHuella->count()
            ]);

            if ($beneficiariosConHuella->isEmpty()) {
                Log::warning('No hay beneficiarios con huella registrada en el sistema');
                return response()->json([
                    'success' => false,
                    'message' => 'No hay beneficiarios con huella registrada en el sistema'
                ], 404);
            }

            $mejorCoincidencia = null;
            $mejorPuntaje = 0;
            $segundoMejorPuntaje = 0;
            $UMBRAL_MINIMO = 100; // Umbral reducido para facilitar identificación
            $DIFERENCIA_MINIMA = 15; // Diferencia mínima reducida para ser más flexible
            $puntajesComparacion = [];

            // Comparar la huella capturada con todas las huellas registradas
            foreach ($beneficiariosConHuella as $beneficiario) {
                try {
                    // Aquí se haría la comparación real usando el SDK
                    // Por ahora simulamos una comparación
                    $puntaje = $this->simularComparacionHuellas($huellaCapturada, $beneficiario->huella_template);
                    
                    $puntajesComparacion[] = [
                        'beneficiario_id' => $beneficiario->id,
                        'codigo' => $beneficiario->codigo,
                        'puntaje' => $puntaje
                    ];
                    
                    if ($puntaje > $mejorPuntaje && $puntaje >= $UMBRAL_MINIMO) {
                        $segundoMejorPuntaje = $mejorPuntaje;
                        $mejorPuntaje = $puntaje;
                        $mejorCoincidencia = $beneficiario;
                    } elseif ($puntaje > $segundoMejorPuntaje) {
                        $segundoMejorPuntaje = $puntaje;
                    }
                } catch (\Exception $e) {
                    Log::warning("Error al comparar huella con beneficiario {$beneficiario->id}: " . $e->getMessage());
                    continue;
                }
            }

            Log::info('Resultados de comparación de huellas', [
                'mejor_puntaje' => $mejorPuntaje,
                'segundo_mejor_puntaje' => $segundoMejorPuntaje,
                'diferencia' => $mejorPuntaje - $segundoMejorPuntaje,
                'umbral_minimo' => $UMBRAL_MINIMO,
                'diferencia_minima' => $DIFERENCIA_MINIMA,
                'beneficiario_identificado' => $mejorCoincidencia ? $mejorCoincidencia->id : null,
                'todos_los_puntajes' => $puntajesComparacion
            ]);

            // Validar que haya una diferencia significativa entre el mejor y segundo mejor puntaje
            $diferenciaConSegundo = $mejorPuntaje - $segundoMejorPuntaje;
            
            // Si el mejor puntaje es muy alto (>160), ser más permisivo con la diferencia
            $diferenciaRequerida = $mejorPuntaje > 160 ? 10 : $DIFERENCIA_MINIMA;
            
            if ($mejorCoincidencia && $diferenciaConSegundo >= $diferenciaRequerida) {
                return response()->json([
                    'success' => true,
                    'message' => 'Beneficiario identificado exitosamente',
                    'beneficiario' => [
                        'id' => $mejorCoincidencia->id,
                        'nombre' => $mejorCoincidencia->nombre_completo,
                        'codigo' => $mejorCoincidencia->codigo,
                        'grado' => $mejorCoincidencia->grado,
                        'grupo' => $mejorCoincidencia->grupo
                    ],
                    'puntaje_coincidencia' => $mejorPuntaje
                ]);
            } else {
                $razon = '';
                if (!$mejorCoincidencia) {
                    $razon = 'No se encontró beneficiario con puntaje suficiente';
                } elseif ($diferenciaConSegundo < $diferenciaRequerida) {
                    $razon = 'La diferencia con el segundo mejor puntaje es insuficiente';
                }
                
                Log::warning('No se encontró beneficiario con coincidencia suficiente', [
                    'mejor_puntaje' => $mejorPuntaje,
                    'segundo_mejor_puntaje' => $segundoMejorPuntaje,
                    'diferencia' => $diferenciaConSegundo,
                    'umbral_minimo' => $UMBRAL_MINIMO,
                    'diferencia_minima' => $DIFERENCIA_MINIMA,
                    'razon' => $razon,
                    'total_beneficiarios_comparados' => count($puntajesComparacion)
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró ningún beneficiario que coincida con la huella capturada. ' . $razon
                ], 404);
            }

        } catch (\Exception $e) {
            Log::error('Error al identificar beneficiario por huella: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al identificar el beneficiario: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Simular comparación de huellas (reemplazar con SDK real)
     */
    private function simularComparacionHuellas($huella1, $huella2): int
    {
        // Esta es una simulación. En producción se debe usar el SDK real
        // Por ahora simulamos una comparación más realista
        
        // Si las huellas son exactamente idénticas (muy raro en capturas reales)
        if ($huella1 === $huella2) {
            return rand(180, 200);
        }
        
        // Simulación más realista: comparar longitud y algunos caracteres
        $longitud1 = strlen($huella1);
        $longitud2 = strlen($huella2);
        
        // Si las longitudes son muy diferentes, probablemente no es la misma persona
        if (abs($longitud1 - $longitud2) > 50) {
            return rand(0, 80);
        }
        
        // Comparar caracteres para simular coincidencia parcial (más realista)
        $coincidencias = 0;
        $minLongitud = min($longitud1, $longitud2);
        $caracteresAComparar = min(150, $minLongitud); // Comparar menos caracteres para ser más permisivo
        
        for ($i = 0; $i < $caracteresAComparar; $i++) {
            if ($huella1[$i] === $huella2[$i]) {
                $coincidencias++;
            }
        }
        
        // Bonus por similitud básica si las huellas tienen características similares
        $bonusSimilitud = 0;
        if ($minLongitud > 30 && $coincidencias > 3) {
            $bonusSimilitud = 15; // Bonus por similitud básica
        }
        
        $coincidencias += $bonusSimilitud;
        $porcentajeCoincidencia = ($coincidencias / $caracteresAComparar) * 100;
        
        // Simular puntaje basado en porcentaje de coincidencia (más permisivo pero inteligente)
        if ($porcentajeCoincidencia > 70) {
            // Muy alta coincidencia - muy probablemente la misma persona
            return rand(170, 200);
        } elseif ($porcentajeCoincidencia > 55) {
            // Alta coincidencia - probablemente la misma persona
            return rand(150, 169);
        } elseif ($porcentajeCoincidencia > 40) {
            // Coincidencia media-alta - suficiente para identificación
            return rand(130, 149);
        } elseif ($porcentajeCoincidencia > 25) {
            // Coincidencia media - suficiente para identificación
            return rand(110, 129);
        } elseif ($porcentajeCoincidencia > 15) {
            // Coincidencia baja pero aceptable
            return rand(100, 109);
        } else {
            // Muy poca coincidencia - probablemente no es la misma persona
            return rand(0, 99);
        }
    }
}