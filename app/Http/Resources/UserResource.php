<?php

namespace App\Http\Resources;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            $this->with = User::getMetaData();
        }
        return $this->with;
    }

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'phone' => $this->phone,
            'created_at' => $this->created_at,
            'status' => $this->status,
            'roles' => RoleResource::collection($this->roles),
            'first_name' => $this->first_name,
            'second_name' => $this->last_name,
            'third_name' => $this->third_name,
            'avatar' => $this->avatar,
            'subscribed' => $this->subscribed,
            'permissions' => $this->permissions,
            'identity_verified_at' => $this->identity_verified_at,
        ];
    }
}
