<?php

namespace Akkurate\LaravelCore\Database\Seeders\Access;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
        ]);
    }

}
