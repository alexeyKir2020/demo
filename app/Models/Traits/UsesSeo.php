<?php

namespace App\Models\Traits;

trait UsesSeo {
    public function fillWithRelation(array $request)
    {
        foreach ($request as $key => $value)
        {
            if (is_array($value) && method_exists($this, $key))
            {
                $this->{$key}->fill($value);
                unset($request[$key]);
            }
        }

        return $this->fill($request);
    }

    public function seo() {
        return $this->hasOne(UsesSeo::class);
    }
}
