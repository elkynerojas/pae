<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;

class AyudaSistema extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    
    protected static string $view = 'filament.pages.ayuda-sistema';
    
    protected static ?string $navigationGroup = 'Sistema';
    
    protected static ?int $navigationSort = 106;
    
    protected static ?string $title = 'Ayuda - Configuración del Sistema';
    
    protected static ?string $navigationLabel = 'Ayuda - Sistema';
    
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
