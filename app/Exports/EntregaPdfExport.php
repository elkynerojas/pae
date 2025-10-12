<?php

namespace App\Exports;

use App\Models\Entrega;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EntregaPdfExport implements FromView, WithTitle, WithColumnWidths, WithStyles
{
    protected $entrega;

    public function __construct(Entrega $entrega)
    {
        $this->entrega = $entrega;
    }

    public function view(): View
    {
        return view('exports.entrega-pdf', [
            'entrega' => $this->entrega,
            'beneficiarios' => $this->entrega->beneficiariosPorEntrega()->with('beneficiario')->get(),
            'productosRacion' => $this->entrega->racion->productosPorRacion()->with('producto.presentacionProducto')->get(),
        ]);
    }

    public function title(): string
    {
        return 'Entrega_' . $this->entrega->fecha->format('Y-m-d');
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15, // Código
            'B' => 25, // Nombres
            'C' => 25, // Apellidos
            'D' => 15, // Grado
            'E' => 10, // Grupo
            'F' => 12, // Raciones
            'G' => 30, // Observaciones
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
