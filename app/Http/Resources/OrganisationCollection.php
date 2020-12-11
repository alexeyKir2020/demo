<?php

namespace App\Http\Resources;

use App\Models\Meta\City;
use App\Models\Meta\OrganisationType;
use App\Models\Organisation;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrganisationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public $collects = 'App\Http\Resources\OrganisationResource';

    public function toArray($request)
    {
        $result = [
            'data' => $this->collection,
        ];

        if($request->query('relations', false)) {
            $meta = Organisation::getMetaData();
            $result = array_merge($result, $meta);
        }

        return $result;
    }
}
