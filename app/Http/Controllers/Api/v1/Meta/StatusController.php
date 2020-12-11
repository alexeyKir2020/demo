<?php


namespace App\Http\Controllers\Api\v1\Meta;

use App\Http\Controllers\Api\v1\Meta\Traits\UsesCRUD;
use App\Http\Controllers\Controller;
use App\Http\Resources\MetaCollection;
use App\Models\Meta\Status;
use App\Models\User;

class StatusController extends Controller
{
    protected $model = Status::class;

    public function index()
    {
        //$this->authorize('index', User::class);

        return response(new MetaCollection(($this->model)::all()));
    }
}




