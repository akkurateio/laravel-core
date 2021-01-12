<?php

namespace Akkurate\LaravelCore\Console\Core;

use Illuminate\Console\Command;

class InstallCore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:install {--refresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the Core resources, alter some files to get all the datas for a new project';

    /**
     * Execute the console command.
     *
     * @return false
     */
    public function handle()
    {
        //Change the auth default user
        if ($this->overwriteConfigKey('auth.php', 'auth.providers.users.model', 'Akkurate\LaravelCore\Models\User')) {
            $this->info('Default auth user set');
        }

        //Change the api guard driver
        if ($this->overwriteConfigKey('auth.php', 'auth.guards.api.driver', 'passport')) {
            $this->info('Default auth api driver set');
        }

        if ($this->option('refresh')){
            $this->call('migrate:fresh');
        } else {
            $this->call('migrate');
        }

        $this->call('db:seed', ['--class' => 'Akkurate\LaravelCore\Database\Seeders\Access\DatabaseSeeder']);
        $this->call('db:seed', ['--class' => 'Akkurate\LaravelContact\Database\Seeders\DatabaseSeeder']);
        $this->call('db:seed', ['--class' => 'Akkurate\LaravelCore\Database\Seeders\Admin\DatabaseSeeder']);
        $this->call('db:seed', ['--class' => 'Akkurate\LaravelCore\Database\Seeders\Access\UserHasRolesTableSeeder']);

        $this->call('passport:install');
        $this->call('back-components:install');
        $this->call('storage:link');
    }

    protected function overwriteConfigKey($file, $key, $value): bool
    {
        if(file_put_contents($this->laravel->configPath($file), str_replace(
            config($key),
            $value,
            file_get_contents($this->laravel->configPath($file))
        ))) {
            config()->set($key, $value);
            return true;
        }
    }
}
