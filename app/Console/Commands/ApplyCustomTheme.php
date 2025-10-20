<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ApplyCustomTheme extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:apply';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aplica el tema personalizado de Filament';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Aplicando tema personalizado de Filament...');
        
        // Crear directorios si no existen
        $cssDir = public_path('css/filament/admin');
        if (!is_dir($cssDir)) {
            mkdir($cssDir, 0755, true);
            $this->info('Directorio CSS creado: ' . $cssDir);
        }
        
        // Copiar archivos CSS mejorados
        $themeCss = resource_path('css/filament/admin/theme-improved.css');
        $customCss = resource_path('css/filament/admin/custom-styles-improved.css');
        
        if (file_exists($themeCss)) {
            copy($themeCss, public_path('css/filament/admin/theme-improved.css'));
            $this->info('Archivo theme-improved.css copiado');
        }
        
        if (file_exists($customCss)) {
            copy($customCss, public_path('css/filament/admin/custom-styles-improved.css'));
            $this->info('Archivo custom-styles-improved.css copiado');
        }
        
        // Limpiar caché
        $this->call('config:clear');
        $this->call('view:clear');
        $this->call('cache:clear');
        
        $this->info('¡Tema personalizado aplicado exitosamente!');
        $this->info('Colores principales:');
        $this->line('  - Primario: #F5276C');
        $this->line('  - Secundario: #F54927');
        $this->line('  - Terciario: #F5B027');
        
        return Command::SUCCESS;
    }
}
