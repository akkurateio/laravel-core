<?php

namespace Akkurate\LaravelCore\Providers;

use Akkurate\LaravelCore\Console\Admin\AdminSeed;
use Akkurate\LaravelCore\Models\Account;
use Akkurate\LaravelCore\Observers\Admin\AccountObserver;
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
            $this->loadRoutesFrom(__DIR__.'/../../routes/laravel-admin/web.php');
        }
        if (config('laravel-admin.routes.api.enabled')) {
            $this->loadRoutesFrom(__DIR__.'/../../routes/laravel-admin/api.php');
        }

        $this->loadViewsFrom(__DIR__ . '/../../resources/laravel-admin/views', 'admin');

        $this->loadMigrationsFrom(__DIR__ . '/../../database/laravel-admin/migrations');

        $this->publishes([
            __DIR__.'/../../resources/laravel-admin/js' => resource_path('js/vendor/admin')
        ], 'js');

        $this->publishes([
            __DIR__.'/../../config/laravel-admin/laravel-admin.php' => config_path('laravel-admin.php')
        ], 'config');

        $this->publishes([
            __DIR__.'/../../resources/laravel-admin/views' => resource_path('views/vendor/admin'),
        ], 'views');

        if ($this->app->runningInConsole()) {
            $this->commands([
                AdminSeed::class
            ]);
        }

        //Observers
        Account::observe(AccountObserver::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/laravel-admin/laravel-admin.php',
            'laravel-admin'
        );
    }
}
