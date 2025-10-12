<?php

namespace App\Filament\Resources\RacionResource\Pages;

use App\Filament\Resources\RacionResource;
use App\Services\LogSistemaService;
use Filament\Resources\Pages\CreateRecord;

class CreateRacion extends CreateRecord
{
    protected static string $resource = RacionResource::class;

    protected function afterCreate(): void
    {
        // Registrar en log
        LogSistemaService::crear(
            'raciones',
            $this->record->id,
            $this->record->toArray(),
            "Nueva ración creada: '{$this->record->nombre}'"
        );
    }
}
