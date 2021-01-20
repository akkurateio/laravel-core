<?php

namespace Akkurate\LaravelCore;

use Akkurate\LaravelCore\Console\Core\InstallCore;
use Akkurate\LaravelCore\Http\CoreKernel;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

/**
 * Config service provider
 *
 */
class LaravelCoreServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $router->pushMiddlewareToGroup('akk-back', CoreKernel::class);
        $router->pushMiddlewareToGroup('akk-api', CoreKernel::class);

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        $this->loadViewsFrom(__DIR__ . '/../resources/core/views', 'core');

        $this->configurePublishing();
        $this->configureCommands();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/general.php',
            'general'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/../config/laravel-core.php',
            'laravel-core'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/../config/laravel-form-builder.php',
            'laravel-form-builder'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/../config/reference.php',
            'reference'
        );
    }

    /**
     * Configure the commands offered by the application.
     *
     * @return void
     */
    protected function configureCommands()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            InstallCore::class,
        ]);
    }

    /**
     * Configure publishing for the package.
     *
     * @return void
     */
    protected function configurePublishing()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__ . '/../resources/core/views' => resource_path('views/vendor/core'),
        ], 'dashboard');

        $this->publishes([
            __DIR__ . '/../config/reference.php' => config_path('reference.php'),
            __DIR__ . '/../config/laravel-core.php' => config_path('laravel-core.php'),
            __DIR__ . '/../config/general.php' => config_path('general.php')
        ], 'config');

        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'core-migrations');
    }
}
