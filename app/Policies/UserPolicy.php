<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if($user->hasRole(Role::ADMIN))
            return true;
    }

    public function index(User $user)
    {
        return $user->hasPermissionTo('users.index');
    }

    public function show(User $user, User $showUser)
    {
        return (
            (
                $user->hasPermissionTo('users.show')
                && ($user->id == $showUser->id)
            )
            || $user->hasPermissionTo('users.show.any')
        );
    }

    public function store(User $user)
    {
        return $user->hasPermissionTo('users.store');
    }

    public function update(User $user, User $updatedUser)
    {
        return (
            (
                $user->hasPermissionTo('users.update')
                && ($user->id == $updatedUser->id)
            )
            || $user->hasPermissionTo('users.update.any')
        );
    }

    public function alterAllFields(User $user)
    {
        return $user->hasPermissionTo('users.alterFields.all');
    }

    public function delete(User $user, $deleteUser)
    {
        return (
            (
                $user->hasPermissionTo('users.delete')
                && ($user->id == $deleteUser->id)
            )
            || $user->hasPermissionTo('users.delete.any')
        );
    }

    public function hardDelete(User $user)
    {
        return $user->hasPermissionTo('users.hardDelete');
    }
}
