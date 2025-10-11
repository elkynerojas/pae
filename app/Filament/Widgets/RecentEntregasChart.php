<?php

namespace App\Filament\Widgets;

use App\Models\Entrega;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class RecentEntregasChart extends ChartWidget
{
    protected static ?string $heading = 'Entregas de los Últimos 7 Días';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('d/m');
            $data[] = Entrega::whereDate('fecha', $date)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Entregas',
                    'data' => $data,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
