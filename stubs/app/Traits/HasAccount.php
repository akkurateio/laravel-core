<?php

namespace App\Traits;

use App\Models\Account;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait HasAccount
 */
trait HasAccount
{
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function accounts()
    {
        return $this->belongsToMany(Account::class, 'admin_account_user');
    }

    public function scopeAccount(Builder $query, $account_uuid)
    {
        $query->whereHas('account', function (Builder $query) use ($account_uuid) {
            $query->where('uuid', $account_uuid);
        });
    }

    /**
     * Scope a query to only include users from auth user administrable account(s).
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFromAdministrableAccount($query)
    {
        if (! auth()->user()->hasRole('superadmin')) {
            if (auth()->user()->admin()) {
                $children = auth()->user()->account->children->pluck('id');

                return $query
                    ->where('account_id', auth()->user()->account_id)
                    ->orWhereIn('account_id', $children);
            } else {
                return $query
                    ->where('uuid', auth()->user()->uuid);
            }
        }
    }
}
