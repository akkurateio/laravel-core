<?php

namespace Akkurate\LaravelCore\Database\Seeders\Access;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('laravel-access.roles') as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                ['label' => $role['label'] ?? null]
            );
        }
    }

}
