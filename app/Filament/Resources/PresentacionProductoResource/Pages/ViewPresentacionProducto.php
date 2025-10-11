<?php

namespace App\Filament\Resources\PresentacionProductoResource\Pages;

use App\Filament\Resources\PresentacionProductoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPresentacionProducto extends ViewRecord
{
    protected static string $resource = PresentacionProductoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
