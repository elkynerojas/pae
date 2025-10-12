<?php

namespace App\Providers;

use App\Models\Entrega;
use App\Models\BeneficiarioPorEntrega;
use App\Policies\EntregaPolicy;
use App\Policies\BeneficiarioPorEntregaPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Entrega::class => EntregaPolicy::class,
        BeneficiarioPorEntrega::class => BeneficiarioPorEntregaPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}