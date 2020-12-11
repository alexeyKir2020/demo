<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait UsesSlugs
{
    public function slug($action, $forAdmin = false)
    {
        return url(($forAdmin? "/admin": "")."/".$this->slug."/".$this->id."/".$action);
    }
}
