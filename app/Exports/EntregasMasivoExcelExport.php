<?php

namespace App\Exports;

use App\Models\Entrega;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EntregasMasivoExcelExport implements WithMultipleSheets
{
    use Exportable;

    protected $entregas;

    public function __construct($entregas)
    {
        $this->entregas = $entregas;
    }

    public function sheets(): array
    {
        $sheets = [];
        
        foreach ($this->entregas as $index => $entrega) {
            $sheets[] = new EntregaExcelExport($entrega);
        }
        
        return $sheets;
    }
}
