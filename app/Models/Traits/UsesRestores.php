<?php

namespace App\Models\Traits;

trait UsesRestores
{
    public function restoreSoftDeleted()
    {
        if($this->trashed()) {
            $this->setStatus($this->previous_status);

            return $this->restore();
        }

        return false;
    }
}

