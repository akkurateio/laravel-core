<?php

namespace Akkurate\LaravelCore\Database\Seeders\Admin;

use Akkurate\LaravelCore\Models\Country;
use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::create([
            'name' => 'France',
            'code' => 'FR',
            'priority' => 0,
            'is_active' => 1
        ]);
    }
}
