<?php

namespace App\Filament\Resources\BeneficiarioResource\Pages;

use App\Filament\Resources\BeneficiarioResource;
use App\Services\LogSistemaService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBeneficiario extends EditRecord
{
    protected static string $resource = BeneficiarioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Registrar en log
        LogSistemaService::actualizar(
            'beneficiarios',
            $this->record->id,
            $this->record->getOriginal(),
            $this->record->toArray(),
            "Beneficiario actualizado: '{$this->record->nombre} {$this->record->apellido}'"
        );
    }
}
