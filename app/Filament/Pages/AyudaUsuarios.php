<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;

class AyudaUsuarios extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static string $view = 'filament.pages.ayuda-usuarios';
    
    protected static ?string $navigationGroup = 'Sistema';
    
    protected static ?int $navigationSort = 101;
    
    protected static ?string $title = 'Ayuda - Gestión de Usuarios';
    
    protected static ?string $navigationLabel = 'Ayuda - Usuarios';
    
    protected static bool $shouldRegisterNavigation = false; // No aparece en el menú principal

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
