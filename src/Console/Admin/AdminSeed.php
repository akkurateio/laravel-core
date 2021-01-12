<?php

namespace Akkurate\LaravelCore\Console\Admin;

use Illuminate\Console\Command;

class AdminSeed extends Command
{
    protected $signature = 'admin:seed';
    protected $description = 'Seed the Admin package from the config file';

    public function handle()
    {
        $this->call('db:seed', [
            '--class' => 'Akkurate\\LaravelCore\\Database\\Seeders\\Admin\\DatabaseSeeder'
        ]);
    }
}
