<?php

namespace App\Exports;

use App\Models\Entrega;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ReporteEntregasExcelExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithEvents
{
    protected $entregas;
    protected $filtros;

    public function __construct($entregas, $filtros = [])
    {
        $this->entregas = $entregas;
        $this->filtros = $filtros;
    }

    public function collection()
    {
        return $this->entregas;
    }

    public function headings(): array
    {
        return [
            'Fecha',
            'Ración',
            'Estado',
            'Total Beneficiarios',
            'Total Raciones',
            'Fecha Cierre',
            'Usuario Cierre',
            'Observaciones',
        ];
    }

    public function map($entrega): array
    {
        return [
            $entrega->fecha->format('d/m/Y'),
            $entrega->racion->nombre ?? 'N/A',
            $entrega->estado === 'cerrada' ? 'Cerrada' : 'Abierta',
            $entrega->beneficiarios->count(),
            $entrega->beneficiarios->sum('pivot.cantidad_raciones'),
            $entrega->fecha_cierre ? $entrega->fecha_cierre->format('d/m/Y H:i') : 'N/A',
            $entrega->usuarioCierre->name ?? 'N/A',
            $entrega->observaciones ?? '',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 12, // Fecha
            'B' => 20, // Ración
            'C' => 12, // Estado
            'D' => 18, // Total Beneficiarios
            'E' => 15, // Total Raciones
            'F' => 18, // Fecha Cierre
            'G' => 20, // Usuario Cierre
            'H' => 30, // Observaciones
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Estilo para el encabezado
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1f2937'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Aplicar bordes a todas las celdas con datos
                $lastRow = $sheet->getHighestRow();
                $lastColumn = $sheet->getHighestColumn();
                
                $sheet->getStyle('A1:' . $lastColumn . $lastRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => 'd1d5db'],
                        ],
                    ],
                ]);
                
                // Centrar columnas específicas
                $sheet->getStyle('A:A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('C:C')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('D:E')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('F:F')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                
                // Agregar información de filtros si existen
                if (!empty($this->filtros)) {
                    $infoRow = $lastRow + 2;
                    $sheet->setCellValue('A' . $infoRow, 'Filtros aplicados:');
                    $sheet->getStyle('A' . $infoRow)->getFont()->setBold(true);
                    
                    $row = $infoRow + 1;
                    foreach ($this->filtros as $key => $value) {
                        if (!empty($value)) {
                            $label = $this->getFilterLabel($key);
                            $sheet->setCellValue('A' . $row, $label . ': ' . $value);
                            $row++;
                        }
                    }
                    
                    $sheet->setCellValue('A' . ($row + 1), 'Reporte generado el: ' . now()->format('d/m/Y H:i:s'));
                }
            },
        ];
    }

    private function getFilterLabel($key): string
    {
        $labels = [
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_fin' => 'Fecha Fin',
            'estado' => 'Estado',
            'racion_id' => 'Ración',
            'beneficiario_id' => 'Beneficiario',
            'grado' => 'Grado',
            'grupo' => 'Grupo',
        ];
        
        return $labels[$key] ?? ucfirst(str_replace('_', ' ', $key));
    }
}
