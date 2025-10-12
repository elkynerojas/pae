<?php

namespace App\Filament\Resources\TipoProductoResource\Pages;

use App\Filament\Resources\TipoProductoResource;
use App\Services\LogSistemaService;
use Filament\Resources\Pages\CreateRecord;

class CreateTipoProducto extends CreateRecord
{
    protected static string $resource = TipoProductoResource::class;

    protected function afterCreate(): void
    {
        // Registrar en log
        LogSistemaService::crear(
            'tipos_productos',
            $this->record->id,
            $this->record->toArray(),
            "Nuevo tipo de producto creado: '{$this->record->nombre}'"
        );
    }
}
