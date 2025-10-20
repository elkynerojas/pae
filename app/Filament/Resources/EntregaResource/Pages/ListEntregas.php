<?php

namespace App\Filament\Resources\EntregaResource\Pages;

use App\Filament\Resources\EntregaResource;
use App\Filament\Pages\ReportesEntregas;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEntregas extends ListRecords
{
    protected static string $resource = EntregaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('reportes')
                ->label('Generar Reportes')
                ->icon('heroicon-o-chart-bar')
                ->color('info')
                ->url(fn (): string => ReportesEntregas::getUrl())
                ->openUrlInNewTab(false),
        ];
    }
}
