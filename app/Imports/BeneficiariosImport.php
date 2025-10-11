<?php

namespace App\Imports;

use App\Models\Beneficiario;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class BeneficiariosImport implements ToCollection, WithValidation, WithBatchInserts, WithChunkReading
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        // Saltar la primera fila (encabezados)
        $rows = $collection->skip(1);
        
        foreach ($rows as $row) {
            // Debug: mostrar los datos que llegan
            echo "Datos de fila: " . json_encode($row) . PHP_EOL;
            
            // Acceder a los datos por índice en lugar de por clave
            $codigo = $row[0] ?? null;
            $nombres = $row[1] ?? '';
            $apellidos = $row[2] ?? '';
            $fechaNacimiento = $row[3] ?? null;
            $genero = $row[4] ?? '';
            $grado = $row[5] ?? '';
            $grupo = $row[6] ?? '';
            $observaciones = $row[7] ?? '';
            $activo = $row[8] ?? true;
            
            // Convertir fecha de nacimiento si viene como string
            if (!empty($fechaNacimiento)) {
                try {
                    $fechaNacimiento = Carbon::parse($fechaNacimiento)->format('Y-m-d');
                } catch (\Exception $e) {
                    $fechaNacimiento = null;
                }
            }

            // Normalizar género
            $genero = $this->normalizarGenero($genero);

            // Convertir activo a boolean
            $activo = $this->convertirABoolean($activo);

            // Generar código automático si no se proporciona
            if (empty($codigo)) {
                $codigo = 'BEN' . str_pad(Beneficiario::count() + 1, 3, '0', STR_PAD_LEFT);
            }

            $beneficiarioData = [
                'codigo' => $codigo,
                'nombres' => $nombres,
                'apellidos' => $apellidos,
                'fecha_nacimiento' => $fechaNacimiento,
                'genero' => $genero,
                'grado' => $grado,
                'grupo' => $grupo,
                'observaciones' => $observaciones,
                'activo' => $activo,
            ];
            
            echo "Datos del beneficiario: " . json_encode($beneficiarioData) . PHP_EOL;
            
            Beneficiario::create($beneficiarioData);
        }
    }

    /**
     * Reglas de validación para las filas
     */
    public function rules(): array
    {
        return [
            'codigo' => 'nullable|string|max:255',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'genero' => 'required|in:masculino,femenino,M,F',
            'grado' => 'nullable|string|max:255',
            'grupo' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string',
            'activo' => 'nullable|boolean',
        ];
    }

    /**
     * Normalizar el valor de género
     */
    private function normalizarGenero($genero)
    {
        $genero = strtolower(trim($genero));
        
        return match ($genero) {
            'm', 'masculino', 'male' => 'masculino',
            'f', 'femenino', 'female' => 'femenino',
            default => 'masculino', // Valor por defecto
        };
    }

    /**
     * Convertir valor a boolean
     */
    private function convertirABoolean($valor)
    {
        if (is_bool($valor)) {
            return $valor;
        }

        $valor = strtolower(trim($valor));
        
        return match ($valor) {
            '1', 'true', 'si', 'sí', 'yes', 'activo' => true,
            '0', 'false', 'no', 'inactivo' => false,
            default => true, // Valor por defecto
        };
    }

    /**
     * Tamaño del lote para inserción
     */
    public function batchSize(): int
    {
        return 1000;
    }

    /**
     * Tamaño del chunk para lectura
     */
    public function chunkSize(): int
    {
        return 1000;
    }
}