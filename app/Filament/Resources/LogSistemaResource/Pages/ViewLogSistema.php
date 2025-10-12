<?php

namespace App\Filament\Resources\LogSistemaResource\Pages;

use App\Filament\Resources\LogSistemaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLogSistema extends ViewRecord
{
    protected static string $resource = LogSistemaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('volver')
                ->label('Volver a Lista')
                ->icon('heroicon-o-arrow-left')
                ->url(fn () => LogSistemaResource::getUrl('index')),
        ];
    }
}
