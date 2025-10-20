<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class AyudaBackup extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    
    protected static string $view = 'filament.pages.ayuda-backup';
    
    protected static ?string $navigationGroup = null;
    
    protected static ?string $title = 'Ayuda - Sistema de Backup';
    
    protected static ?int $navigationSort = 6;
    
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
    
    public static function getNavigationLabel(): string
    {
        return 'Ayuda - Backup';
    }
}
