<?php

namespace Akkurate\LaravelCore\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Access service provider
 *
 */
class LaravelMeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('laravel-me.routes.back.enabled')) {
            $this->loadRoutesFrom(__DIR__.'/../../routes/me/web.php');
        }

        $this->loadViewsFrom(__DIR__ . '/../../resources/me/views', 'me');

        $this->publishes([
            __DIR__.'/../../config/me/laravel-me.php' => config_path('laravel-me.php')
        ], 'config');

        $this->publishes([
            __DIR__.'/../../resources/me/views/back/users/partials/delete.blade.php' => resource_path('views/vendor/me/back/users/partials/delete.blade.php'),
        ], 'user-partials');

        $this->publishes([
            __DIR__.'/../../resources/me/views' => resource_path('views/vendor/me'),
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
            __DIR__.'/../../config/me/laravel-me.php',
            'laravel-me'
        );
    }
}
