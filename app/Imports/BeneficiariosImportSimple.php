<?php

namespace App\Imports;

use App\Models\Beneficiario;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BeneficiariosImportSimple implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Normalizar género
        $genero = $this->normalizarGenero($row['genero'] ?? 'masculino');
        
        // Generar código automático si no se proporciona
        $codigo = $row['codigo'] ?? null;
        if (empty($codigo)) {
            $codigo = 'BEN' . str_pad(Beneficiario::count() + time(), 3, '0', STR_PAD_LEFT);
        }
        
        return new Beneficiario([
            'codigo' => $codigo,
            'nombres' => $row['nombres'] ?? '',
            'apellidos' => $row['apellidos'] ?? '',
            'fecha_nacimiento' => $row['fecha_nacimiento'] ?? null,
            'genero' => $genero,
            'grado' => $row['grado'] ?? '',
            'grupo' => $row['grupo'] ?? '',
            'observaciones' => $row['observaciones'] ?? '',
            'activo' => $this->convertirABoolean($row['activo'] ?? true),
        ]);
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
}
