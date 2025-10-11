<?php

namespace App\Filament\Resources\RacionResource\Pages;

use App\Filament\Resources\RacionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRacion extends ViewRecord
{
    protected static string $resource = RacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // Los widgets se mostrarán después de la información básica
        ];
    }
}
