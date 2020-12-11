<?php


namespace App\Http\Controllers\Api\v1\Meta;

use App\Http\Controllers\Api\v1\Meta\Traits\UsesCRUD;
use App\Http\Controllers\Controller;
use App\Models\Meta\City;
use App\Models\User;

class CityController extends Controller
{
    use UsesCRUD;

    protected $model = City::class;
}




