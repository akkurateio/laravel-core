<?php

namespace Akkurate\LaravelCore\Tests;

use Akkurate\LaravelBackComponents\LaravelBackComponentsServiceProvider;
use Akkurate\LaravelCore\LaravelCoreServiceProvider;
use Akkurate\LaravelCore\Models\User;
use Akkurate\LaravelCore\Providers\LaravelAccessServiceProvider;
use Akkurate\LaravelCore\Providers\LaravelAdminServiceProvider;
use Akkurate\LaravelCore\Providers\LaravelAuthServiceProvider;
use Akkurate\LaravelSearch\LaravelSearchServiceProvider;
use Cviebrock\EloquentSluggable\ServiceProvider as EloquentSluggableServiceProvider;
use Kris\LaravelFormBuilder\FormBuilderServiceProvider;
use Laravel\Passport\PassportServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Spatie\JsonApiPaginate\JsonApiPaginateServiceProvider;
use Spatie\Permission\PermissionServiceProvider;

class TestCase extends OrchestraTestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();

        $this->user = User::where('email', 'user@test.com')->first();
        auth()->login($this->user);
    }

    protected function getPackageProviders($app): array
    {
        return [
            LaravelCoreServiceProvider::class,
            LaravelAccessServiceProvider::class,
            LaravelAdminServiceProvider::class,
            LaravelAuthServiceProvider::class,
            LaravelBackComponentsServiceProvider::class,
            LaravelCoreServiceProvider::class,
            PermissionServiceProvider::class,
            EloquentSluggableServiceProvider::class,
            LaravelSearchServiceProvider::class,
            FormBuilderServiceProvider::class,
            JsonApiPaginateServiceProvider::class,
            PassportServiceProvider::class
        ];
    }

    protected function setUpDatabase()
    {
         $this->artisan('core:install');
    }
}
