<?php

namespace App\Models\Traits;

use App\Models\Status;

trait UsesApproves {

    public function approveLastUpdate($options = []) {

        $attributes = json_decode($this->requested_changes);

        ValidationHelper::validate($attributes, $this->updateRules);

        $this->setStatus(Status::UPDATED);

        if(parent::update($attributes, $options)) {
            $this->fireModelEvent('updated', false);

            return true;
        }

        return false;
    }

    public function approve() {
        $this->setStatus(Status::APPROVED);

        if(parent::save()) {
            $this->fireModelEvent('approved', false);

            return true;
        }

        return false;
    }

}

