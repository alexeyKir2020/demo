<?php


namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OrganisationUpdate;
use App\Http\Resources\OrganisationCollection;
use App\Http\Resources\OrganisationResource;
use App\Models\Meta\City;
use App\Models\Meta\OrganisationType;
use App\Models\Organisation;
use App\Models\User;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Api\OrganisationCreate;
use App\Models\Meta\Status;


class OrganisationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $this->authorize('index', Organisation::class);

        $response = new OrganisationCollection(Organisation::queryByRequest($request));

        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FormRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function store(OrganisationCreate $request)
    {
        $organisation = Organisation::create($request->validated());

        return response(new OrganisationResource($organisation), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $organisation
     * @return \Illuminate\Http\Response
     */
    public function show(Organisation $organisation)
    {
        $this->authorize('show', $organisation);

        return new OrganisationResource($organisation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FormRequest  $request
     * @param  User  $organisation
     * @return \Illuminate\Http\Response
     */

    public function update(OrganisationUpdate $request, Organisation $organisation)
    {
        $organisation->update($request->validated());

        return response(['message' => "Updated succesfully"], Response::HTTP_NO_CONTENT);
    }

    /**
     * Soft remove the specified resource from storage.
     *
     * @param  User  $organisation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organisation $organisation)
    {
        $this->authorize('delete', $organisation);

        $organisation->delete();

        return response(['message' => "Deleted succesfully"], Response::HTTP_NO_CONTENT);
    }

    /**
     * Hard remove the specified resource from storage.
     *
     * @param  User  $organisation
     * @return \Illuminate\Http\Response
     */
    public function hardDelete(Organisation $organisation)
    {
        $this->authorize('hardDelete', Organisation::class);

        $organisation->hardDelete();

        return response(['message' => "Deleted succesfully"], Response::HTTP_NO_CONTENT);
    }
}




