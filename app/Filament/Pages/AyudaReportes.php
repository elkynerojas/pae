<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;

class AyudaReportes extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    
    protected static string $view = 'filament.pages.ayuda-reportes';
    
    protected static ?string $navigationGroup = 'Sistema';
    
    protected static ?int $navigationSort = 105;
    
    protected static ?string $title = 'Ayuda - Reportes y Análisis';
    
    protected static ?string $navigationLabel = 'Ayuda - Reportes';
    
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
