<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ApplyPastelPalette extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:apply-pastel {palette}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aplica una paleta de colores pasteles específica';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $paletteName = $this->argument('palette');
        
        $palettes = [
            'lavender' => [
                'name' => 'Lavanda Suave',
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

        if (!isset($palettes[$paletteName])) {
            $this->error("❌ Paleta '{$paletteName}' no encontrada.");
            $this->line('Paletas disponibles: ' . implode(', ', array_keys($palettes)));
            return Command::FAILURE;
        }

        $palette = $palettes[$paletteName];
        
        $this->info("🎨 Aplicando paleta: {$palette['name']}");
        $this->line("Primario: {$palette['primary']}");
        $this->line("Secundario: {$palette['secondary']}");
        $this->line("Terciario: {$palette['tertiary']}");
        $this->newLine();

        // Crear archivo CSS para la paleta seleccionada
        $this->createPastelCSS($palette, $paletteName);
        
        // Actualizar configuración
        $this->updateConfig($palette);
        
        // Limpiar caché
        $this->call('config:clear');
        $this->call('view:clear');
        
        $this->info("✅ Paleta '{$palette['name']}' aplicada exitosamente!");
        $this->line("Refresca tu navegador para ver los cambios.");
        
        return Command::SUCCESS;
    }

    private function createPastelCSS($palette, $paletteName)
    {
        $css = "/* Tema Pastel: {$palette['name']} */

:root {
    /* Colores principales */
    --color-primary: {$palette['primary']};
    --color-secondary: {$palette['secondary']};
    --color-tertiary: {$palette['tertiary']};
    
    /* Paleta completa */
    --color-primary-50: {$palette['colors'][50]};
    --color-primary-100: {$palette['colors'][100]};
    --color-primary-200: {$palette['colors'][200]};
    --color-primary-300: {$palette['colors'][300]};
    --color-primary-400: {$palette['colors'][400]};
    --color-primary-500: {$palette['colors'][500]};
    --color-primary-600: {$palette['colors'][600]};
    --color-primary-700: {$palette['colors'][700]};
    --color-primary-800: {$palette['colors'][800]};
    --color-primary-900: {$palette['colors'][900]};
    --color-primary-950: {$palette['colors'][950]};
    
    /* Colores de texto optimizados para pasteles */
    --text-on-primary: #FFFFFF;
    --text-on-secondary: #FFFFFF;
    --text-on-tertiary: #000000;
    --text-on-light-primary: {$palette['colors'][900]};
    --text-on-light-secondary: {$palette['colors'][800]};
    --text-on-light-tertiary: {$palette['colors'][700]};
}

/* Botones con estilo pastel */
.fi-btn-primary {
    background-color: var(--color-primary);
    border-color: var(--color-primary);
    color: var(--text-on-primary);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.fi-btn-primary:hover {
    background-color: var(--color-primary-600);
    border-color: var(--color-primary-600);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

/* Sidebar pastel */
.fi-sidebar {
    background: linear-gradient(180deg, var(--color-primary-50) 0%, white 100%);
    border-right: 1px solid var(--color-primary-200);
}

.fi-sidebar-nav-item {
    color: var(--text-on-light-primary);
    border-radius: 8px;
    margin: 2px 8px;
}

.fi-sidebar-nav-item:hover {
    background-color: var(--color-primary-100);
    color: var(--text-on-light-primary);
}

.fi-sidebar-nav-item-active {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-600) 100%);
    color: var(--text-on-primary);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Cards con estilo pastel suave */
.fi-card {
    background: linear-gradient(135deg, white 0%, var(--color-primary-50) 100%);
    border: 1px solid var(--color-primary-200);
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.fi-card:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    transform: translateY(-2px);
    transition: all 0.3s ease-in-out;
}

/* Tablas con headers pastel */
.fi-ta-header-cell {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-600) 100%);
    color: var(--text-on-primary);
    font-weight: 500;
}

.fi-ta-row:hover {
    background-color: var(--color-primary-50);
}

/* Formularios con estilo pastel */
.fi-input:focus {
    border-color: var(--color-primary);
    box-shadow: 0 0 0 3px rgba(0,0,0,0.05);
}

.fi-section-header {
    background: linear-gradient(135deg, var(--color-primary-50) 0%, var(--color-primary-100) 100%);
    border-bottom: 1px solid var(--color-primary-200);
    color: var(--text-on-light-primary);
}

/* Notificaciones pastel */
.fi-notification-success {
    background: linear-gradient(135deg, var(--color-tertiary) 0%, white 100%);
    border-left: 4px solid var(--color-tertiary);
    color: var(--text-on-light-tertiary);
}

.fi-notification-danger {
    background: linear-gradient(135deg, var(--color-secondary) 0%, white 100%);
    border-left: 4px solid var(--color-secondary);
    color: var(--text-on-light-secondary);
}

/* Modo oscuro para pasteles */
@media (prefers-color-scheme: dark) {
    :root {
        --text-on-primary: #FFFFFF;
        --text-on-secondary: #FFFFFF;
        --text-on-tertiary: #FFFFFF;
        --text-on-light-primary: var(--color-primary-200);
        --text-on-light-secondary: var(--color-secondary-200);
        --text-on-light-tertiary: var(--color-tertiary-200);
    }
    
    .fi-card {
        background: linear-gradient(135deg, var(--color-primary-900) 0%, var(--color-primary-800) 100%);
        border-color: var(--color-primary-700);
    }
}";

        file_put_contents(
            resource_path("css/filament/admin/pastel-{$paletteName}.css"),
            $css
        );
        
        $this->info("Archivo CSS creado: pastel-{$paletteName}.css");
    }

    private function updateConfig($palette)
    {
        // Actualizar Tailwind
        $tailwindConfig = file_get_contents(base_path('tailwind.config.js'));
        
        $newColors = json_encode($palette['colors'], JSON_PRETTY_PRINT);
        $newColors = str_replace(['{', '}', '"'], ['', '', ''], $newColors);
        
        $tailwindConfig = preg_replace(
            '/colors:\s*\{[^}]*\}/s',
            "colors: {\n                primary: {\n{$newColors}\n                },\n            }",
            $tailwindConfig
        );
        
        file_put_contents(base_path('tailwind.config.js'), $tailwindConfig);
        
        // Actualizar AdminPanelProvider
        $providerPath = app_path('Providers/Filament/AdminPanelProvider.php');
        $providerContent = file_get_contents($providerPath);
        
        $colorsArray = var_export($palette['colors'], true);
        $providerContent = preg_replace(
            '/\'primary\'\s*=>\s*\[[^\]]*\],/s',
            "'primary' => {$colorsArray},",
            $providerContent
        );
        
        file_put_contents($providerPath, $providerContent);
        
        $this->info("Configuración actualizada");
    }
}
