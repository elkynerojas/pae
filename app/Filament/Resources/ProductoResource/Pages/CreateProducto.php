<?php

namespace App\Filament\Resources\ProductoResource\Pages;

use App\Filament\Resources\ProductoResource;
use App\Services\LogSistemaService;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProducto extends CreateRecord
{
    protected static string $resource = ProductoResource::class;

    protected function afterCreate(): void
    {
        // Registrar en log
        LogSistemaService::crear(
            'productos',
            $this->record->id,
            $this->record->toArray(),
            "Nuevo producto creado: '{$this->record->nombre}'"
        );
    }
}
