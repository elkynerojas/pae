<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Services\LogSistemaService;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function afterCreate(): void
    {
        // Registrar en log
        LogSistemaService::crear(
            'users',
            $this->record->id,
            $this->record->toArray(),
            "Nuevo usuario creado: '{$this->record->name}' ({$this->record->email})"
        );
    }
}
