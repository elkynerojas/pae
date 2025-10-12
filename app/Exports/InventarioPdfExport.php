<?php

namespace App\Exports;

use App\Models\Inventario;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;

class InventarioPdfExport
{
    protected $inventarios;

    public function __construct($inventarios = null)
    {
        $this->inventarios = $inventarios ?? Inventario::with('producto.presentacionProducto', 'producto.tipoProducto')->get();
    }

    public function view(): View
    {
        return view('exports.inventario-pdf', [
            'inventarios' => $this->inventarios,
        ]);
    }

    public function title(): string
    {
        return 'Inventario';
    }
}
