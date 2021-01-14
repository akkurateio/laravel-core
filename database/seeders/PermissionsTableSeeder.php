<?php

namespace Akkurate\LaravelCore\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsTableSeeder extends seeder
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

        foreach (config('laravel-access.permissions') as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                ['label' => $permission['label'] ?? null]
            );
        }

        foreach (config('laravel-admin.permissions') as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                ['label' => $permission['label'] ?? null]
            );
        }

        foreach (config('laravel-admin.roles') as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                ['label' => $role['label'] ?? null]
            );
        }

        foreach (config('laravel-admin.roles_permissions') as $key => $permissions) {
            $role = Role::where('name', '!=', 'superadmin')->where('name', $key)->first();
            foreach ($permissions as $permission) {
                $role->givePermissionTo($permission);
            }
        }

    }

}
