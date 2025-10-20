<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;

class AyudaBeneficiarios extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    
    protected static string $view = 'filament.pages.ayuda-beneficiarios';
    
    protected static ?string $navigationGroup = 'Sistema';
    
    protected static ?int $navigationSort = 102;
    
    protected static ?string $title = 'Ayuda - Gestión de Beneficiarios';
    
    protected static ?string $navigationLabel = 'Ayuda - Beneficiarios';
    
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
