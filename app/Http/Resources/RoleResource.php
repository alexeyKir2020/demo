<?php

namespace App\Http\Resources;

use App\Models\Event;
use App\Models\Meta\City;
use App\Models\Meta\CostType;
use App\Models\Meta\EventType;
use App\Models\Meta\Status;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
