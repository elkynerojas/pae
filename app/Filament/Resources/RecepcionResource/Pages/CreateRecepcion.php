<?php

namespace App\Filament\Resources\RecepcionResource\Pages;

use App\Filament\Resources\RecepcionResource;
use App\Services\LogSistemaService;
use Filament\Resources\Pages\CreateRecord;

class CreateRecepcion extends CreateRecord
{
    protected static string $resource = RecepcionResource::class;

    protected function afterCreate(): void
    {
        // Registrar en log
        LogSistemaService::crear(
            'recepciones',
            $this->record->id,
            $this->record->toArray(),
            "Nueva recepción creada para el proveedor: '{$this->record->proveedor}'"
        );
    }
}
