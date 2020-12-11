<?php

namespace App\Models\Traits;
use App\Models\Meta\Status;

trait UsesDeletes
{
    public function delete()
    {
        foreach ($this->relations as $relation) {
            $this->{$relation}()->delete();
        }

        $this->status = Status::DELETED;

        return parent::delete();
    }

    public function isDeleted()
    {
        return $this->status == Status::DELETED;
    }

    public function hardDelete()
    {

        foreach ($this->relations as $relation) {
            $this->{$relation}()->forceDelete();
        }

        $this->forceDelete();

        if (!$this->exists) {
            $this->fireModelEvent('destroyed', false);

            return true;
        }

        return false;
    }
}

