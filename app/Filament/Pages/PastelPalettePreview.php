<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class PastelPalettePreview extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';
    
    protected static string $view = 'filament.pages.pastel-palette-preview';
    
    protected static ?string $title = 'Preview de Paletas Pasteles';
    
    protected static ?string $navigationLabel = 'Preview Paletas';
    
    protected static ?int $navigationSort = 99;
    
    public function getPalettes()
    {
        return [
            'lavender' => [
                'name' => 'Lavanda Suave',
                'description' => 'Tonos lavanda y violeta suaves',
                'primary' => '#B19CD9',
                'secondary' => '#C7CEEA',
                'tertiary' => '#E8D5F2',
                'colors' => [
                    50 => '#F8F6FF',
                    100 => '#F0EBFF',
                    200 => '#E1D7FF',
                    300 => '#C7B8FF',
                    400 => '#B19CD9',
                    500 => '#9B7ED1',
                    600 => '#8B6BC7',
                    700 => '#7B5ABD',
                    800 => '#6B49B3',
                    900 => '#5B38A9',
                    950 => '#4B27A0',
                ]
            ],
            'mint' => [
                'name' => 'Menta Fresca',
                'description' => 'Verdes menta y azules suaves',
                'primary' => '#81C784',
                'secondary' => '#A5D6A7',
                'tertiary' => '#C8E6C9',
                'colors' => [
                    50 => '#F1F8E9',
                    100 => '#E8F5E8',
                    200 => '#D1EDD1',
                    300 => '#B8E6B8',
                    400 => '#9FDF9F',
                    500 => '#81C784',
                    600 => '#66BB6A',
                    700 => '#4CAF50',
                    800 => '#43A047',
                    900 => '#388E3C',
                    950 => '#2E7D32',
                ]
            ],
            'peach' => [
                'name' => 'Durazno Suave',
                'description' => 'Tonos durazno y coral suaves',
                'primary' => '#FFB74D',
                'secondary' => '#FFCC80',
                'tertiary' => '#FFE0B2',
                'colors' => [
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
                ]
            ],
            'sage' => [
                'name' => 'Salvia Elegante',
                'description' => 'Verdes salvia y grises suaves',
                'primary' => '#A5A5A5',
                'secondary' => '#BDBDBD',
                'tertiary' => '#E0E0E0',
                'colors' => [
                    50 => '#FAFAFA',
                    100 => '#F5F5F5',
                    200 => '#EEEEEE',
                    300 => '#E0E0E0',
                    400 => '#BDBDBD',
                    500 => '#A5A5A5',
                    600 => '#9E9E9E',
                    700 => '#757575',
                    800 => '#616161',
                    900 => '#424242',
                    950 => '#212121',
                ]
            ],
            'rose' => [
                'name' => 'Rosa Suave',
                'description' => 'Rosas y cremas delicados',
                'primary' => '#F8BBD9',
                'secondary' => '#FCE4EC',
                'tertiary' => '#FFF0F5',
                'colors' => [
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
                ]
            ],
            'sky' => [
                'name' => 'Cielo Azul',
                'description' => 'Azules cielo y blancos suaves',
                'primary' => '#90CAF9',
                'secondary' => '#BBDEFB',
                'tertiary' => '#E3F2FD',
                'colors' => [
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
                ]
            ],
            'cream' => [
                'name' => 'Crema Elegante',
                'description' => 'Tonos crema y beige suaves',
                'primary' => '#D7CCC8',
                'secondary' => '#EFEBE9',
                'tertiary' => '#F5F5F5',
                'colors' => [
                    50 => '#F5F5F5',
                    100 => '#EFEBE9',
                    200 => '#E0E0E0',
                    300 => '#D7CCC8',
                    400 => '#BCAAA4',
                    500 => '#A1887F',
                    600 => '#8D6E63',
                    700 => '#795548',
                    800 => '#6D4C41',
                    900 => '#5D4037',
                    950 => '#4E342E',
                ]
            ],
            'lilac' => [
                'name' => 'Lila Suave',
                'description' => 'Lilas y violetas pastel',
                'primary' => '#CE93D8',
                'secondary' => '#E1BEE7',
                'tertiary' => '#F3E5F5',
                'colors' => [
                    50 => '#F3E5F5',
                    100 => '#E1BEE7',
                    200 => '#CE93D8',
                    300 => '#BA68C8',
                    400 => '#AB47BC',
                    500 => '#9C27B0',
                    600 => '#8E24AA',
                    700 => '#7B1FA2',
                    800 => '#6A1B9A',
                    900 => '#4A148C',
                    950 => '#38006B',
                ]
            ],
            'combined' => [
                'name' => 'Combinado Armonioso',
                'description' => 'Durazno + Cielo + Rosa en perfecta armonía',
                'primary' => '#FFB74D',
                'secondary' => '#90CAF9',
                'tertiary' => '#F8BBD9',
                'colors' => [
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
                ]
            ]
        ];
    }
}
