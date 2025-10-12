<?php

namespace App\Filament\Resources\RecepcionResource\Pages;

use App\Filament\Resources\RecepcionResource;
use App\Services\LogSistemaService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRecepcion extends EditRecord
{
    protected static string $resource = RecepcionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Registrar en log
        LogSistemaService::actualizar(
            'recepciones',
            $this->record->id,
            $this->record->getOriginal(),
            $this->record->toArray(),
            "Recepción actualizada para el proveedor: '{$this->record->proveedor}'"
        );
    }
}
