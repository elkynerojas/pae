<?php

namespace App\Filament\Resources\RacionResource\Pages;

use App\Filament\Resources\RacionResource;
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
}
