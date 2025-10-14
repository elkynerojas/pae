<?php

namespace App\Http\Controllers;

use App\Models\Beneficiario;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class HuellaDigitalController extends Controller
{
    /**
     * Obtiene todas las plantillas de huellas para comparación
     * Esta función es necesaria para verificar duplicados desde JavaScript
     */
    public function obtenerTodasPlantillas(): JsonResponse
    {
        try {
            $plantillas = Beneficiario::whereNotNull('huella_template')
                ->pluck('huella_template', 'id')
                ->toArray();

            return response()->json([
                'success' => true,
                'templates' => array_values($plantillas),
                'count' => count($plantillas)
            ]);

        } catch (\Exception $e) {
            Log::error('Error obteniendo plantillas: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las plantillas'
            ], 500);
        }
    }

}
