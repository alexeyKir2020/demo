<?php

namespace App\Http\Resources;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    public $collects = 'App\Http\Resources\UserResource';
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $result = [
            'data' => $this->collection,
        ];

        if($request->query('relations', false)) {
            $meta = User::getMetaData();
            $result = array_merge($result, $meta);
        }

        return $result;
    }


}
