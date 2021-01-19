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
        //Change the api guard driver
        $this->replaceInFile("'driver' => 'token',", "'driver' => 'passport',", $this->laravel->configPath('auth.php'));

        // "Home" Route...
        $this->replaceInFile('/home', '/brain', app_path('Providers/RouteServiceProvider.php'));

        // Copy files to the application and replace occurrences inside it.
        $this->call('account-submodule:install');

        $this->line('');
        $this->line('Fresh migrate is starting now');
        $this->line('');

        $this->call('migrate:fresh', ['--seed' => true]);

        $this->line('');
        $this->call('passport:install');
        $this->line('');
        $this->call('back-components:install');
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
