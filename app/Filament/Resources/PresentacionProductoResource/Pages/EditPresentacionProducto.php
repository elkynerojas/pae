<?php

namespace App\Filament\Resources\PresentacionProductoResource\Pages;

use App\Filament\Resources\PresentacionProductoResource;
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
}
