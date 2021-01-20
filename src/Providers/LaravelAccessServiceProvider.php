<?php

namespace Akkurate\LaravelCore\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

/**
 * LaravelAccess service provider
 *
 */
class LaravelAccessServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('superadmin') ? true : null;
        });

        $this->loadRoutesFrom(__DIR__.'/../../routes/access/api.php');
        $this->loadRoutesFrom(__DIR__.'/../../routes/access/web.php');

        $this->loadViewsFrom(__DIR__ . '/../../resources/access/views', 'access');

        $this->publishes([
            __DIR__.'/../../config/access.php' => config_path('laravel-access.php')
        ], 'config');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/access.php',
            'laravel-access'
        );
    }
}
