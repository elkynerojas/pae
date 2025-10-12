<?php

namespace App\Filament\Resources\PresentacionProductoResource\Pages;

use App\Filament\Resources\PresentacionProductoResource;
use App\Services\LogSistemaService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPresentacionProducto extends EditRecord
{
    protected static string $resource = PresentacionProductoResource::class;

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
            'presentaciones_productos',
            $this->record->id,
            $this->record->getOriginal(),
            $this->record->toArray(),
            "Presentación de producto actualizada: '{$this->record->nombre}'"
        );
    }
}
