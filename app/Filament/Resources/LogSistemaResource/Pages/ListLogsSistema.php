<?php

namespace App\Filament\Resources\LogSistemaResource\Pages;

use App\Filament\Resources\LogSistemaResource;
use App\Services\LogSistemaService;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListLogsSistema extends ListRecords
{
    protected static string $resource = LogSistemaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('estadisticas')
                ->label('Estadísticas')
                ->icon('heroicon-o-chart-bar')
                ->color('info')
                ->modalContent(function () {
                    $estadisticas = LogSistemaService::estadisticas(30);
                    
                    return view('filament.pages.estadisticas-logs', [
                        'estadisticas' => $estadisticas
                    ]);
                })
                ->modalWidth('4xl'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'todos' => Tab::make('Todos')
                ->icon('heroicon-o-clipboard-document-list'),
            'creaciones' => Tab::make('Creaciones')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('accion', 'CREATE'))
                ->icon('heroicon-o-plus-circle')
                ->badge(fn () => \App\Models\LogSistema::where('accion', 'CREATE')->count()),
            'actualizaciones' => Tab::make('Actualizaciones')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('accion', 'UPDATE'))
                ->icon('heroicon-o-pencil-square')
                ->badge(fn () => \App\Models\LogSistema::where('accion', 'UPDATE')->count()),
            'eliminaciones' => Tab::make('Eliminaciones')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('accion', 'DELETE'))
                ->icon('heroicon-o-trash')
                ->badge(fn () => \App\Models\LogSistema::where('accion', 'DELETE')->count()),
            'sesiones' => Tab::make('Sesiones')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('accion', ['LOGIN', 'LOGOUT']))
                ->icon('heroicon-o-user')
                ->badge(fn () => \App\Models\LogSistema::whereIn('accion', ['LOGIN', 'LOGOUT'])->count()),
            'exportaciones' => Tab::make('Exportaciones')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('accion', ['EXPORT', 'IMPORT']))
                ->icon('heroicon-o-arrow-down-tray')
                ->badge(fn () => \App\Models\LogSistema::whereIn('accion', ['EXPORT', 'IMPORT'])->count()),
        ];
    }
}
