<?php

namespace App\Filament\Resources\ProductoResource\Pages;

use App\Filament\Resources\ProductoResource;
use App\Services\LogSistemaService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProducto extends EditRecord
{
    protected static string $resource = ProductoResource::class;

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
            'productos',
            $this->record->id,
            $this->record->getOriginal(),
            $this->record->toArray(),
            "Producto actualizado: '{$this->record->nombre}'"
        );
    }
}
