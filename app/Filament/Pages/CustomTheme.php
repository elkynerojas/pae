<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class CustomTheme extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';
    
    protected static string $view = 'filament.pages.custom-theme';
    
    protected static ?string $title = 'Tema Personalizado';
    
    protected static ?string $navigationLabel = 'Tema Personalizado';
    
    protected static ?int $navigationSort = 100;
}
