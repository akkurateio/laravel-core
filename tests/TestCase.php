<?php

namespace Akkurate\LaravelCore\Tests;

use Akkurate\LaravelAccountSubmodule\Database\Seeders\DatabaseSeeder;
use Akkurate\LaravelAccountSubmodule\LaravelAccountSubmoduleServiceProvider;
use Akkurate\LaravelBackComponents\LaravelBackComponentsServiceProvider;
use Akkurate\LaravelCore\LaravelCoreServiceProvider;
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

        $this->createUser();

        $this->user = user()->where('email', 'user@tester.com')->first();
        auth()->login($this->user);
    }

    protected function getEnvironmentSetUp($app)
    {
        // Use test User model for users provider
        $app['config']->set('auth.providers.users.model', userClass());
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
            PassportServiceProvider::class,
            LaravelAccountSubmoduleServiceProvider::class
        ];
    }

    protected function setUpDatabase()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../vendor/akkurateio/laravel-account-submodule/database/migrations');
        $this->seed(DatabaseSeeder::class);
    }

    protected function createUser()
    {
        $account = account()->create([
            'name' => 'Account',
            'slug' => 'account',
            'email' => 'account@test.com',
        ]);

        $user = user()->forceCreate([
            'firstname' => 'Username',
            'lastname' => 'User',
            'email' => 'user@tester.com',
            'password' => 'test',
            'account_id' => $account->id,
        ]);

        $user->preference()->create();
        $account->preference()->create();
    }
}
