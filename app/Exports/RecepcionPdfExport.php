<?php

namespace App\Exports;

use App\Models\Recepcion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;

class RecepcionPdfExport
{
    protected Recepcion $recepcion;

    public function __construct(Recepcion $recepcion)
    {
        $this->recepcion = $recepcion;
    }

    public function view(): View
    {
        return view('exports.recepcion-pdf', [
            'recepcion' => $this->recepcion,
            'productosRecepcion' => $this->recepcion->productosPorRecepcion()->with('producto.presentacionProducto')->get(),
        ]);
    }

    public function title(): string
    {
        return 'Recepcion_' . $this->recepcion->fecha->format('Y-m-d');
    }
}
