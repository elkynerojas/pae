<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;

class AyudaOperaciones extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    
    protected static string $view = 'filament.pages.ayuda-operaciones';
    
    protected static ?string $navigationGroup = 'Sistema';
    
    protected static ?int $navigationSort = 104;
    
    protected static ?string $title = 'Ayuda - Operaciones';
    
    protected static ?string $navigationLabel = 'Ayuda - Operaciones';
    
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
