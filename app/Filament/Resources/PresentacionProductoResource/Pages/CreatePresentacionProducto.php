<?php

namespace App\Filament\Resources\PresentacionProductoResource\Pages;

use App\Filament\Resources\PresentacionProductoResource;
use App\Services\LogSistemaService;
use Filament\Resources\Pages\CreateRecord;

class CreatePresentacionProducto extends CreateRecord
{
    protected static string $resource = PresentacionProductoResource::class;

    protected function afterCreate(): void
    {
        // Registrar en log
        LogSistemaService::crear(
            'presentaciones_productos',
            $this->record->id,
            $this->record->toArray(),
            "Nueva presentación de producto creada: '{$this->record->nombre}'"
        );
    }
}
