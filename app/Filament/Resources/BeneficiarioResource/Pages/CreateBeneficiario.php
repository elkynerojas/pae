<?php

namespace App\Filament\Resources\BeneficiarioResource\Pages;

use App\Filament\Resources\BeneficiarioResource;
use App\Services\LogSistemaService;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBeneficiario extends CreateRecord
{
    protected static string $resource = BeneficiarioResource::class;

    protected function afterCreate(): void
    {
        // Registrar en log
        LogSistemaService::crear(
            'beneficiarios',
            $this->record->id,
            $this->record->toArray(),
            "Nuevo beneficiario creado: '{$this->record->nombre} {$this->record->apellido}'"
        );
    }
}
