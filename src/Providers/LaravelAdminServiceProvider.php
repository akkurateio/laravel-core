<?php

namespace Akkurate\LaravelCore\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * LaravelCore service provider
 *
 */
class LaravelAdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('laravel-admin.routes.back.enabled')) {
            $this->loadRoutesFrom(__DIR__.'/../../routes/admin/web.php');
        }
        if (config('laravel-admin.routes.api.enabled')) {
            $this->loadRoutesFrom(__DIR__.'/../../routes/admin/api.php');
        }

        $this->loadViewsFrom(__DIR__ . '/../../resources/admin/views', 'admin');

        $this->publishes([
            __DIR__.'/../../resources/admin/js' => resource_path('js/vendor/admin')
        ], 'js');

        $this->publishes([
            __DIR__.'/../../config/admin.php' => config_path('laravel-admin.php')
        ], 'config');

        $this->publishes([
            __DIR__.'/../../resources/admin/views' => resource_path('views/vendor/admin'),
        ], 'views');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/admin.php',
            'laravel-admin'
        );
    }
}
