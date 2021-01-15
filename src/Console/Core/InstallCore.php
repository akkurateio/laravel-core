<?php

namespace Akkurate\LaravelCore\Console\Core;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class InstallCore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:install';

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
        // Publish Migrations...
        $this->callSilent('vendor:publish', ['--tag' => 'core-migrations', '--force' => true]);

        //Change the api guard driver
        $this->replaceInFile("'driver' => 'token',", "'driver' => 'passport',", $this->laravel->configPath('auth.php'));

        // "Home" Route...
        $this->replaceInFile('/home', '/brain', app_path('Providers/RouteServiceProvider.php'));

        // Run the install of the core package
        $this->installCore();

        $answer = $this->choice('You prefer to launch migrate fresh or simple migrate ?', ['simple', 'fresh'], 'simple');

        if ($answer === 'simple') {
            $this->call('migrate', ['--seed' => true]);
        } else {
            $this->call('migrate:fresh', ['--seed' => true]);
        }

        $this->line('');
        $this->call('passport:install');
        $this->line('');
        $this->call('back-components:install');
    }

    /**
     * Copy the files
     */
    protected function installCore()
    {
        // Policies...
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/app/Policies', app_path('Policies'));

        // Factories...
        copy(__DIR__.'/../../../database/factories/UserFactory.php', base_path('database/factories/UserFactory.php'));
        copy(__DIR__.'/../../../database/factories/AccountFactory.php', base_path('database/factories/AccountFactory.php'));

        // Service Providers...
        copy(__DIR__.'/../../../stubs/app/Providers/AuthServiceProvider.php', app_path('Providers/AuthServiceProvider.php'));

        // Seeders...
        (new Filesystem)->copyDirectory(__DIR__.'/../../../database/seeders', base_path('database/seeders'));

        // Models...
        copy(__DIR__.'/../../../stubs/app/Models/User.php', app_path('Models/User.php'));
        copy(__DIR__.'/../../../stubs/app/Models/Account.php', app_path('Models/Account.php'));

        $this->line('');
        $this->comment('Core package installed, just a last question before you go');
        $this->line('');
    }

    /**
     * Replace a given string within a given file.
     *
     * @param string $search
     * @param string $replace
     * @param string $path
     * @return void
     */
    protected function replaceInFile(string $search, string $replace, string $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }
}
