<?php

namespace App\Http\Resources;

use App\Models\Meta\City;
use App\Models\Meta\OrganisationType;
use App\Models\Organisation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganisationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        if($request->query('relations', false)) {
            $this->with = Organisation::getMetaData();
        }
        return $this->with;
    }

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'link' => $this->link,
            'organisation_type' => new MetaResource($this->organisation_types),
            'city' => new MetaResource($this->city),
            'reg_number' => $this->reg_number,
            'email' => $this->email,
            'logo' => $this->avatar,
            'contact_person' => $this->contact_person,
            'phone' => $this->phone,
            'status' => $this->status,
            'previous_status' => $this->previous_status,
            'requested_changes' => $this->requested_changes,
            'addition_phone' => $this->addition_phone,
            'addition_email' => $this->addition_email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
