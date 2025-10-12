<?php

namespace App\Exports;

use App\Models\Recepcion;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RecepcionesMasivoExcelExport implements WithMultipleSheets
{
    use Exportable;

    protected $recepciones;

    public function __construct($recepciones)
    {
        $this->recepciones = $recepciones;
    }

    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->recepciones as $recepcion) {
            $sheets[] = new RecepcionExcelExport($recepcion);
        }

        return $sheets;
    }
}
