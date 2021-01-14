<?php

namespace Akkurate\LaravelCore\Database\Seeders;

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
            CountriesTableSeeder::class,
            LanguagesTableSeeder::class,
            RolesTableSeeder::class,
            PermissionsTableSeeder::class,
            AccountsTableSeeder::class,
            UsersTableSeeder::class,
            UserHasRolesTableSeeder::class
        ]);
    }

}