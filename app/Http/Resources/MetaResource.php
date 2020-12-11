<?php

namespace App\Http\Resources;

use App\Models\Meta\City;
use App\Models\Meta\OrganisationType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

class MetaResource extends JsonResource
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
            'value' => $this->when(($this->value !== null), $this->value),
        ];
    }
}
