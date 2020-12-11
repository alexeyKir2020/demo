<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait UsesRoleSetter
{
    public function setRole($role)
    {
        if($role) {
            $this->role = $role;

            return true;
        }

        return false;
    }
}
