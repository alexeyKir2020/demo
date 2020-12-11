<?php

namespace App\Models\Traits;

use App\Models\Meta\Status;
use Illuminate\Support\Str;

trait UsesStatuses
{
    public function setStatusAttribute($status) : bool
    {
        if(isset($status)) {
            $this->previous_status = $this->status ?? Status::CREATED;
            $this->attributes['status'] = $status;

            switch ($status) {
                case Status::WAITING_APPROVAL :
                    $this->fireModelEvent('waitingApproval', false);
                    break;
                case Status::PUBLISHED :
                    $this->fireModelEvent('published', false);
                    break;
                case Status::SUSPENDED:
                    $this->fireModelEvent('suspended', false);
                    break;
                case Status::APPROVED:
                    $this->fireModelEvent('approved', false);
                    break;
                case Status::ARCHIVED:
                    $this->fireModelEvent('archived', false);
                    break;
            }

            $this->fireModelEvent('rolesAssigned', false);

            return true;
        }

        return false;
    }


    public function isSuspended(): bool
    {
        return $this->getStatus() == Status::SUSPENDED;
    }

    private function getStatus() {
        return $this->status;
    }
}
