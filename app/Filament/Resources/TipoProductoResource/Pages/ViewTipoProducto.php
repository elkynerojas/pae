<?php

namespace App\Filament\Resources\TipoProductoResource\Pages;

use App\Filament\Resources\TipoProductoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTipoProducto extends ViewRecord
{
    protected static string $resource = TipoProductoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
