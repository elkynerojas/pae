<?php

namespace App\Exports;

use App\Models\Recepcion;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RecepcionExcelExport implements FromView, WithTitle, WithColumnWidths, WithStyles
{
    protected Recepcion $recepcion;

    public function __construct(Recepcion $recepcion)
    {
        $this->recepcion = $recepcion;
    }

    public function view(): View
    {
        return view('exports.recepcion-excel', [
            'recepcion' => $this->recepcion,
            'productosRecepcion' => $this->recepcion->productosPorRecepcion()->with('producto.presentacionProducto')->get(),
        ]);
    }

    public function title(): string
    {
        return 'Recepcion_' . $this->recepcion->fecha->format('Y-m-d');
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15, // Código
            'B' => 25, // Nombre del Producto
            'C' => 20, // Presentación
            'D' => 15, // Cantidad
            'E' => 30, // Observaciones
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Estilo para el encabezado
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 14,
                ],
                'alignment' => [
                    'horizontal' => 'center',
                ],
            ],
            // Estilo para los títulos de columna
            3 => [
                'font' => [
                    'bold' => true,
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => [
                        'rgb' => 'E5E7EB',
                    ],
                ],
            ],
        ];
    }
}
