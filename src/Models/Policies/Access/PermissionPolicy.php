<?php

namespace Akkurate\LaravelCore\Models\Policies\Access;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
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
        return $user->can('list permissions');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Permission  $permission
     * @return mixed
     */
    public function view(User $user, Permission  $permission)
    {
        return $user->can('read permission');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('create permission');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Permission  $permission
     * @return mixed
     */
    public function update(User $user, Permission $permission)
    {
        return $user->can('update permission');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Permission  $permission
     * @return mixed
     */
    public function delete(User $user, Permission $permission)
    {
        return $user->can('delete permission');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  Permission  $permission
     * @return mixed
     */
    public function restore(User $user, Permission $permission)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  Permission  $permission
     * @return mixed
     */
    public function forceDelete(User $user, Permission $permission)
    {
        //
    }
}
