<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;

class AyudaInventario extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    
    protected static string $view = 'filament.pages.ayuda-inventario';
    
    protected static ?string $navigationGroup = 'Sistema';
    
    protected static ?int $navigationSort = 103;
    
    protected static ?string $title = 'Ayuda - Gestión de Inventario';
    
    protected static ?string $navigationLabel = 'Ayuda - Inventario';
    
    protected static bool $shouldRegisterNavigation = false;

    public function getActions(): array
    {
        return [
            Action::make('volver_ayuda')
                ->label('Volver al Centro de Ayuda')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(route('filament.admin.pages.ayuda')),
        ];
    }
}
