<?php

namespace Akkurate\LaravelCore\Database\Seeders\Admin;

use Akkurate\LaravelCore\Models\Language;
use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::create([
            'label' => 'français',
            'locale' => 'fr',
            'locale_php' => 'fr_FR',
            'is_default' => 1
        ]);
        Language::create([
            'label' => 'anglais',
            'locale' => 'en',
            'locale_php' => 'en_EN',
            'is_default' => 1
        ]);
    }
}
