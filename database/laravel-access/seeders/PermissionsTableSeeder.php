<?php

namespace Akkurate\LaravelCore\Database\Seeders\Access;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('laravel-access.permissions') as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                ['label' => $permission['label'] ?? null]
            );
        }
    }

}
