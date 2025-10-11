<?php

namespace App\Providers;

use App\Models\BeneficiarioPorEntrega;
use App\Models\Entrega;
use App\Observers\BeneficiarioPorEntregaObserver;
use App\Observers\EntregaObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Entrega::observe(EntregaObserver::class);
        BeneficiarioPorEntrega::observe(BeneficiarioPorEntregaObserver::class);
    }
}