<?php

namespace App\Filament\Resources\RacionResource\Pages;

use App\Filament\Resources\RacionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRaciones extends ListRecords
{
    protected static string $resource = RacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
