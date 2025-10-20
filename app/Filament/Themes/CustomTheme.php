<?php

namespace App\Filament\Themes;

use Filament\Support\Facades\FilamentColor;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;

class CustomTheme
{
    public static function boot(): void
    {
        // Registrar los colores personalizados del tema definitivo
        FilamentColor::register([
            'primary' => [
                50 => '#FFF0F5',
                100 => '#FCE4EC',
                200 => '#F8BBD9',
                300 => '#F48FB1',
                400 => '#F06292',
                500 => '#EC407A',
                600 => '#E91E63',
                700 => '#D81B60',
                800 => '#C2185B',
                900 => '#AD1457',
                950 => '#880E4F',
            ],
            'secondary' => [
                50 => '#FFF8E1',
                100 => '#FFECB3',
                200 => '#FFE082',
                300 => '#FFD54F',
                400 => '#FFCA28',
                500 => '#FFB74D',
                600 => '#FFA726',
                700 => '#FF9800',
                800 => '#F57C00',
                900 => '#EF6C00',
                950 => '#E65100',
            ],
            'tertiary' => [
                50 => '#E3F2FD',
                100 => '#BBDEFB',
                200 => '#90CAF9',
                300 => '#64B5F6',
                400 => '#42A5F5',
                500 => '#2196F3',
                600 => '#1E88E5',
                700 => '#1976D2',
                800 => '#1565C0',
                900 => '#0D47A1',
                950 => '#0A3D91',
            ],
        ]);

        // Registrar estilos personalizados - Tema Definitivo
        FilamentView::registerRenderHook(
            PanelsRenderHook::STYLES_AFTER,
            fn (): HtmlString => new HtmlString(
                '<link rel="stylesheet" href="' . asset('css/filament/admin/pastel-combined.css') . '">'
            )
        );
    }
}
