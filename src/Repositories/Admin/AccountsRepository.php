<?php

namespace Akkurate\LaravelCore\Repositories\Admin;

use Akkurate\LaravelCore\Models\Account;

class AccountsRepository implements AccountsRepositoryInterface
{
    public function search(string $query = null)
    {
        return Account::where('name', 'like', "%{$query}%")
            ->orWhere('internal_reference', 'like', "%{$query}%")
            ->orWhereHas('addresses', function ($q) {
                $query = request('q');
                $q->where('city', 'like', "%{$query}%");
            })
            ->orWhereHas('phones', function ($q) {
                $query = request('q');
                $q->where('number', 'like', "%{$query}%");
            })
            ->administrable()
            ->orderBy('id', 'desc')
            ->paginate(10);
    }
}
