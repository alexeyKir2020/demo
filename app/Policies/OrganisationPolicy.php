<?php

namespace App\Policies;

use App\Models\Organisation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\Response;

class OrganisationPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if($user->hasRole(Role::ADMIN))
            return true;
    }

    public function index(User $user)
    {
        return $user->hasPermissionTo('organisations.index.any');
    }

    public function selfIndex(User $user)
    {
        return $user->hasPermissionTo('organisations.index');
    }

    public function show(User $user, Organisation $organisation)
    {
        $isMember = $organisation
            ->users()
            ->where("user_id", $user->id)
            ->exists();

        return (
            (
                $user->hasPermissionTo('organisations.show')
                && $isMember
            )
            || $user->hasPermissionTo('organisations.show.any')
        );
    }

    public function store(User $user)
    {
        return $user->hasPermissionTo('organisations.store');
    }

    public function update(User $user, Organisation $organisation)
    {
        $isOwner = $organisation
            ->users()
            ->where("user_id", "=", $user->id)
            ->where('is_owner', '=', true)
            ->exists();
        $test = $user->hasPermissionTo('organisations.update');
        $test5 = $user->roles()->get();
        $test2 = $isOwner;
        $test3 = $user->hasPermissionTo('organisations.update.any');
        return (
            (
                $user->hasPermissionTo('organisations.update')
                && $isOwner
            )
            || ($user->hasPermissionTo('organisations.update.any'))
        );
    }

    public function alterAllFields(User $user)
    {
        return $user->hasPermissionTo('organisations.alterFields.all');
    }

    public function delete(User $user, Organisation $organisation)
    {
        $isOwner = $organisation
            ->users()
            ->where("user_id", $user->id)
            ->where('is_owner', '=', true)
            ->exists();

        return (
            (
                $user->hasPermissionTo('organisations.delete')
                && $isOwner
            )
            || $user->hasPermissionTo('organisations.delete.any')
        );
    }

    public function hardDelete(User $user)
    {
        return $user->hasPermissionTo('organisations.hardDelete');
    }
}
