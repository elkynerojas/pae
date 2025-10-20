<?php

namespace App\Providers;

use App\Filament\Themes\CustomTheme;
use Illuminate\Support\ServiceProvider;

class FilamentThemeServiceProvider extends ServiceProvider
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
        // Inicializar el tema personalizado
        CustomTheme::boot();
    }
}
