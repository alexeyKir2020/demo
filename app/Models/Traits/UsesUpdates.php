<?php

namespace App\Models\Traits;

use App\Models\Meta\Status;
use Illuminate\Support\Facades\Auth;

trait UsesUpdates {

    public function update(array $attributes = [], array $options = []) {

        if(isset($attributes['status']))
            $this->status = $attributes['status'];

        return parent::update($attributes, $options);
    }

}

