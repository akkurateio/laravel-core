<?php

namespace Akkurate\LaravelCore\Database\Seeders\Access;

use Akkurate\LaravelCore\Models\User;
use Illuminate\Database\Seeder;

class UserHasRolesTableSeeder extends seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('laravel-admin.users') as $user) {
            $newUser = User::where('email', $user['email']['address'])->first();
            $newUser->assignRole($user['role']);
        }
    }
}
