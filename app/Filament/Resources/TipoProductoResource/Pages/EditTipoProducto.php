<?php

namespace App\Filament\Resources\TipoProductoResource\Pages;

use App\Filament\Resources\TipoProductoResource;
use App\Services\LogSistemaService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTipoProducto extends EditRecord
{
    protected static string $resource = TipoProductoResource::class;

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
            'tipos_productos',
            $this->record->id,
            $this->record->getOriginal(),
            $this->record->toArray(),
            "Tipo de producto actualizado: '{$this->record->nombre}'"
        );
    }
}
