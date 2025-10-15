<?php

namespace App\Filament\Resources\BackupResource\Widgets;

use App\Models\Backup;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class BackupStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $estadisticas = Backup::obtenerEstadisticas();
        
        $backupsHoy = Backup::whereDate('fecha_creacion', today())->count();
        $backupsSemana = Backup::where('fecha_creacion', '>=', Carbon::now()->subWeek())->count();
        $backupsMes = Backup::where('fecha_creacion', '>=', Carbon::now()->subMonth())->count();

        return [
            Stat::make('Total de Backups', $estadisticas['total'])
                ->description('Backups en el sistema')
                ->descriptionIcon('heroicon-o-archive-box')
                ->color('primary'),

            Stat::make('Backups Exitosos', $estadisticas['completados'])
                ->description($estadisticas['porcentaje_exito'] . '% de éxito')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Backups Fallidos', $estadisticas['fallidos'])
                ->description('Requieren atención')
                ->descriptionIcon('heroicon-o-x-circle')
                ->color($estadisticas['fallidos'] > 0 ? 'danger' : 'gray'),

            Stat::make('Espacio Utilizado', $estadisticas['tamaño_total_formateado'])
                ->description('Almacenamiento total')
                ->descriptionIcon('heroicon-o-server-stack')
                ->color('info'),

            Stat::make('Backups Hoy', $backupsHoy)
                ->description('Creados hoy')
                ->descriptionIcon('heroicon-o-calendar-days')
                ->color('warning'),

            Stat::make('Backups Recientes', $estadisticas['recientes'])
                ->description('Últimos 7 días')
                ->descriptionIcon('heroicon-o-clock')
                ->color('secondary'),
        ];
    }
}
