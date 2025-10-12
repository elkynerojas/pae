<?php

namespace App\Filament\Resources\RacionResource\Pages;

use App\Filament\Resources\RacionResource;
use App\Services\LogSistemaService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRacion extends EditRecord
{
    protected static string $resource = RacionResource::class;

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
            'raciones',
            $this->record->id,
            $this->record->getOriginal(),
            $this->record->toArray(),
            "Ración actualizada: '{$this->record->nombre}'"
        );
    }
}
