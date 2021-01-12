<?php

namespace Akkurate\LaravelCore\Models\Policies\Admin;

use Akkurate\LaravelCore\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
        return $user->can('list users');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  User  $target
     * @return mixed
     */
    public function view(User $user, User $target)
    {
        $children = auth()->user()->account->children->pluck('id');
        return $user->can('read user')
            && $user->account_id === $target->account_id || $children->contains($target->account_id);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('create user');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  User  $target
     * @return mixed
     */
    public function update(User $user, User $target)
    {
        $children = auth()->user()->account->children->pluck('id');
        return $user->can('update user')
            && $user->account_id === $target->account_id || $children->contains($target->account_id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  User  $target
     * @return mixed
     */
    public function delete(User $user, User $target)
    {
        $children = auth()->user()->account->children->pluck('id');
        return $user->can('delete user')
            && $user->account_id === $target->account_id || $children->contains($target->account_id);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  User  $target
     * @return mixed
     */
    public function restore(User $user, User $target)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  User  $target
     * @return mixed
     */
    public function forceDelete(User $user, User $target)
    {
        //
    }
}
