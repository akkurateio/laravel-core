<?php

namespace Akkurate\LaravelCore\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Config service provider
 *
 */
class LaravelAuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/auth/web/login.php');

        $this->loadRoutesFrom(__DIR__ . '/../../routes/auth/web/register.php');

        if (config('laravel-auth.verify_email')) {
            $this->loadRoutesFrom(__DIR__ . '/../../routes/auth/web/verify.php');
        }

        if (config('laravel-auth.api_enabled')) {
            $this->loadRoutesFrom(__DIR__ . '/../../routes/auth/api.php');
        }

        $this->loadViewsFrom(__DIR__ . '/../../resources/auth/views', 'auth');

        $this->publishes([
            __DIR__.'/../../resources/auth/sass' => resource_path('sass/vendor/auth'),
        ], 'sass');

        $this->publishes([
            __DIR__.'/../../resources/auth/views' => resource_path('views/auth'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../../config/auth/laravel-auth.php' => config_path('laravel-auth.php'),
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
            __DIR__.'/../../config/auth/laravel-auth.php',
            'laravel-auth'
        );
    }
}
