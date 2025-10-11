<?php

namespace App\Filament\Widgets;

use App\Models\Beneficiario;
use App\Models\Entrega;
use App\Models\Producto;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PAEStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Usuarios', User::count())
                ->description('Usuarios registrados en el sistema')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
            
            Stat::make('Beneficiarios Activos', Beneficiario::where('activo', true)->count())
                ->description('Estudiantes beneficiarios activos')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),
            
            Stat::make('Productos Registrados', Producto::count())
                ->description('Productos en el inventario')
                ->descriptionIcon('heroicon-m-cube')
                ->color('info'),
            
            Stat::make('Entregas Realizadas', Entrega::count())
                ->description('Entregas completadas')
                ->descriptionIcon('heroicon-m-truck')
                ->color('warning'),
        ];
    }
}
