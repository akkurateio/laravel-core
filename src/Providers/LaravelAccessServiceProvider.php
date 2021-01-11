<?php

namespace Akkurate\LaravelCore\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * LaravelAccess service provider
 *
 */
class LaravelAccessServiceProvider extends ServiceProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \Spatie\Permission\Models\Role::class => \Akkurate\LaravelAccess\Policies\RolePolicy::class,
        \Spatie\Permission\Models\Permission::class => \Akkurate\LaravelAccess\Policies\PermissionPolicy::class
    ];

	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot()
	{
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            return $user->hasRole('superadmin') ? true : null;
        });

		$this->loadRoutesFrom(__DIR__.'/../../routes/laravel-access/api.php');
		$this->loadRoutesFrom(__DIR__.'/../../routes/laravel-access/web.php');

		$this->loadViewsFrom(__DIR__ . '/../../resources/laravel-access/views', 'access');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/laravel-access/migrations');

        $this->publishes([
            __DIR__.'/../../config/laravel-access/laravel-access.php' => config_path('laravel-access.php')
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
            __DIR__.'/../../config/laravel-access/laravel-access.php', 'laravel-access'
        );
	}
}
