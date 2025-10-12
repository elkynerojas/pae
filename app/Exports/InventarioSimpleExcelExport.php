<?php

namespace App\Exports;

use App\Models\Inventario;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InventarioSimpleExcelExport implements FromView
{
    protected $inventarios;

    public function __construct($inventarios = null)
    {
        $this->inventarios = $inventarios ?? Inventario::with('producto.presentacionProducto', 'producto.tipoProducto')->get();
    }

    public function view(): View
    {
        return view('exports.inventario-excel', [
            'inventarios' => $this->inventarios,
        ]);
    }
}
