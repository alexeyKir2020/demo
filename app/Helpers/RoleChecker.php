<?php

namespace App\Helpers;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class RoleChecker
{
    public static function isAdmin()
    {
        return Auth::user()->hasRole(Role::ADMIN);
    }
}
