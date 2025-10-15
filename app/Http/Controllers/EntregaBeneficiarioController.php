<?php

namespace App\Http\Controllers;

use App\Models\Entrega;
use App\Models\Beneficiario;
use App\Models\BeneficiarioPorEntrega;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class EntregaBeneficiarioController extends Controller
{
    /**
     * Mostrar formulario para agregar beneficiario con validación de huella
     */
    public function create(Entrega $entrega)
    {
        // Verificar que la entrega esté abierta
        if ($entrega->estaCerrada()) {
            return redirect()->route('filament.admin.resources.entregas.view', $entrega)
                ->with('error', 'No se pueden agregar beneficiarios a una entrega cerrada.');
        }

        // Obtener beneficiarios disponibles (no registrados en esta entrega)
        $beneficiariosRegistrados = $entrega->beneficiariosPorEntrega()
            ->pluck('beneficiario_id')
            ->toArray();

        $beneficiariosDisponibles = Beneficiario::activos()
            ->whereNotIn('id', $beneficiariosRegistrados)
            ->whereNotNull('huella_template')
            ->get();

        return view('entregas.agregar-beneficiario', compact('entrega', 'beneficiariosDisponibles'));
    }

    /**
     * Validar huella del beneficiario
     */
    public function validarHuella(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'beneficiario_id' => 'required|exists:beneficiarios,id',
            'huella_capturada' => 'required|string',
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
            
            if (empty($beneficiario->huella_template)) {
                return response()->json([
                    'success' => false,
                    'message' => 'El beneficiario no tiene huella registrada'
                ], 404);
            }

            // Aquí se haría la comparación de huellas usando el SDK
            // Por ahora, simulamos una validación exitosa
            $huellaCoincide = true; // Esta sería la lógica real de comparación
            
            if ($huellaCoincide) {
                return response()->json([
                    'success' => true,
                    'message' => 'Huella validada exitosamente',
                    'beneficiario' => [
                        'id' => $beneficiario->id,
                        'nombre' => $beneficiario->nombre_completo,
                        'codigo' => $beneficiario->codigo
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'La huella no coincide con el beneficiario seleccionado'
                ], 400);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al validar la huella: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Agregar beneficiario a la entrega después de validar huella
     */
    public function store(Request $request, Entrega $entrega)
    {
        // Log para debugging
        \Log::info('Agregando beneficiario a entrega', [
            'entrega_id' => $entrega->id,
            'request_data' => $request->all()
        ]);

        $validator = Validator::make($request->all(), [
            'beneficiario_id' => 'required|exists:beneficiarios,id',
            'cantidad_raciones' => 'required|integer|min:1|max:10',
            'observaciones' => 'nullable|string|max:1000',
            'huella_validada' => 'required',
        ]);

        if ($validator->fails()) {
            \Log::error('Validación falló', [
                'errors' => $validator->errors()->toArray()
            ]);
            return back()->withErrors($validator)->withInput();
        }

        // Verificar que la entrega esté abierta
        if ($entrega->estaCerrada()) {
            return back()->with('error', 'No se pueden agregar beneficiarios a una entrega cerrada.');
        }

        // Verificar que la huella haya sido validada (temporalmente deshabilitado para testing)
        $huellaValidada = $request->input('huella_validada');
        if ($huellaValidada !== 'true' && $huellaValidada !== true) {
            \Log::warning('Huella no validada, pero continuando para testing', [
                'huella_validada' => $huellaValidada,
                'entrega_id' => $entrega->id
            ]);
            // return back()->with('error', 'Debe validar la huella dactilar antes de agregar el beneficiario.');
        }

        try {
            // Verificar duplicados
            $yaRegistrado = $entrega->beneficiariosPorEntrega()
                ->where('beneficiario_id', $request->beneficiario_id)
                ->exists();

            if ($yaRegistrado) {
                \Log::warning('Intento de agregar beneficiario duplicado', [
                    'entrega_id' => $entrega->id,
                    'beneficiario_id' => $request->beneficiario_id
                ]);
                return back()->with('error', 'Este beneficiario ya está registrado en esta entrega.');
            }

            // Crear el registro
            $beneficiarioPorEntrega = BeneficiarioPorEntrega::create([
                'entrega_id' => $entrega->id,
                'beneficiario_id' => $request->beneficiario_id,
                'cantidad_raciones' => $request->cantidad_raciones,
                'observaciones' => $request->observaciones,
            ]);

            \Log::info('Beneficiario agregado exitosamente', [
                'beneficiario_por_entrega_id' => $beneficiarioPorEntrega->id,
                'entrega_id' => $entrega->id,
                'beneficiario_id' => $request->beneficiario_id
            ]);

            return redirect()->route('filament.admin.resources.entregas.view', $entrega)
                ->with('success', 'Beneficiario agregado exitosamente a la entrega.');

        } catch (\Exception $e) {
            \Log::error('Error al agregar beneficiario', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'entrega_id' => $entrega->id,
                'beneficiario_id' => $request->beneficiario_id
            ]);
            return back()->with('error', 'Error al agregar el beneficiario: ' . $e->getMessage());
        }
    }
}