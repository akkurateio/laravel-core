<?php

namespace Akkurate\LaravelCore\Repositories\Admin;

use Akkurate\LaravelCore\Models\User;

class UsersRepository implements UsersRepositoryInterface
{
    public function search(string $query = null)
    {
        $users = User::whereHas('account', function ($q) {
            $query = request('q');
            $q->where('name', 'like', "%{$query}%");
        })
            ->orWhere('firstname', 'like', "%{$query}%")
            ->orWhere('lastname', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhereHas('addresses', function ($q) {
                $query = request('q');
                $q->where('city', 'like', "%{$query}%");
            })
            ->orWhereHas('phones', function ($q) {
                $query = request('q');
                $q->where('number', 'like', "%{$query}%");
            })
            ->fromAdministrableAccount()
            ->get();

        if (request('status') && request('status') == 'deactivated') {
            $users = $users->where('is_active', 0);
        }

        if (request('account') && request('account') != 0) {
            $users = $users->where('account_id', request('account'));
        }

        if (request('role') && request('role') != 'all') {
            $users = $users->filter(function ($user) {
                return $user->hasRole(request('role'));
            });
        }

        return $users;
    }
}
