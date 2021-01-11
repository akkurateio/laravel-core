<?php

namespace Akkurate\LaravelCore\Database\Seeders\Admin;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
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
			AccountsTableSeeder::class,
            PermissionsTableSeeder::class,
            UsersTableSeeder::class
		]);
    }
}
