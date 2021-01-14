<?php

namespace Akkurate\LaravelCore\Database\Seeders;

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
        if (config('laravel-i18n')) {
            Country::create([
                'name' => 'France',
                'code' => 'FR',
                'priority' => 0,
                'is_active' => 1
            ]);
        }
    }
}
