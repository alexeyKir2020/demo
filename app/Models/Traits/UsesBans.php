<?php

namespace App\Models\Traits;

use App\Http\Resources\UserResource;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;

trait UsesBans {

    public function ban()
    {
        /*$this->setStatus(Status::BANNED);

        if(parent::save()) {
            $this->fireModelEvent('banned', false);

            return true;
        }*/

        if(Auth::user()->can('ban', Auth::user())){
            return response('banned', 200);
        }
        else {
            return response('bans', 200);
        }

        return false;
    }

    public function unban()
    {
        if($this->isBanned()) {
            $this->setStatus($this->previous_status);
        }
        else {
            return false;
        }

        if(parent::save()) {
            $this->fireModelEvent('unbanned', false);

            return true;
        }

        return false;
    }

    public function isBanned()
    {
        return $this->status == Status::BANNED;
    }

}

