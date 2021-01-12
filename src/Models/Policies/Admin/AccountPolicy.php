<?php

namespace Akkurate\LaravelCore\Models\Policies\Admin;

use Akkurate\LaravelCore\Models\User;
use Akkurate\LaravelCore\Models\Account;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->hasRole('superadmin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->can('list accounts');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Account  $account
     * @return mixed
     */
    public function view(User $user, Account $account)
    {
        return $user->can('read account')
            && $account->id === auth()->user()->account->id || auth()->user()->accounts->contains($account->id);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('create account');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Account  $account
     * @return mixed
     */
    public function update(User $user, Account $account)
    {
        return $user->can('update account')
            && $account->id === auth()->user()->account->id || auth()->user()->accounts->contains($account->id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Account  $account
     * @return mixed
     */
    public function delete(User $user, Account $account)
    {
        return $user->can('delete account')
            && auth()->user()->accounts->contains($account->id);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  Account  $account
     * @return mixed
     */
    public function restore(User $user, Account $account)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  Account  $account
     * @return mixed
     */
    public function forceDelete(User $user, Account $account)
    {
        //
    }
}
