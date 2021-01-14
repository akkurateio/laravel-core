<?php

namespace Akkurate\LaravelCore\Tests;

use Akkurate\LaravelCore\Providers\LaravelAuthServiceProvider;
use Akkurate\LaravelBackComponents\LaravelBackComponentsServiceProvider;
use Akkurate\LaravelContact\LaravelContactServiceProvider;
use Akkurate\LaravelCore\LaravelCoreServiceProvider;
use Akkurate\LaravelCore\Models\User;
use Akkurate\LaravelCore\Providers\LaravelAccessServiceProvider;
use Akkurate\LaravelCore\Providers\LaravelAdminServiceProvider;
use Akkurate\LaravelMedia\LaravelMediaServiceProvider;
use Akkurate\LaravelSearch\LaravelSearchServiceProvider;
use Cviebrock\EloquentSluggable\ServiceProvider as EloquentSluggableServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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

    protected function getEnvironmentSetUp($app)
    {
        //Set the mail environment
        $app['config']->set('mail.from.address', 'hello@akkurate.com');
        $app['config']->set('mail.from.name', 'Akkurate');
        $app['config']->set('mail.mailers.smtp.host', 'maildev');
        $app['config']->set('mail.mailers.smtp.port', 25);
        $app['config']->set('mail.mailers.smtp.encryption', null);
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
            LaravelContactServiceProvider::class,
            FormBuilderServiceProvider::class,
            JsonApiPaginateServiceProvider::class,
            LaravelMediaServiceProvider::class,
            PassportServiceProvider::class
        ];
    }

    protected function setUpDatabase()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        $this->loadMigrationsFrom(__DIR__ . '/../vendor/akkurate/laravel-media/database/migrations');

        $this->artisan('core:install');
    }
}
