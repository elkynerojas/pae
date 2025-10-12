<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

class LanguageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Establecer el idioma por defecto a español
        App::setLocale('es');
        
        // Configurar el idioma para las rutas de Filament
        if (request()->is('admin*')) {
            App::setLocale('es');
        }
    }
}
