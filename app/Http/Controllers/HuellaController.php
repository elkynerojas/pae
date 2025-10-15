<?php

namespace App\Http\Controllers;

use App\Models\Beneficiario;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

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
}