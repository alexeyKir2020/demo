<?php


namespace App\Http\Controllers\Api\v1\Meta;

use App\Http\Controllers\Api\v1\Meta\Traits\UsesCRUD;
use App\Http\Controllers\Controller;
use App\Models\Meta\OrganisationType;
use App\Models\User;


class OrganisationTypeController extends Controller
{
    use UsesCRUD;

    protected $model = OrganisationType::class;
}
