<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        \App\Models\Cliente::class => \App\Policies\ClientePolicy::class,
        \App\Models\Divida::class => \App\Policies\DividaPolicy::class,
        \App\Models\Cobranca::class => \App\Policies\CobrancaPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
