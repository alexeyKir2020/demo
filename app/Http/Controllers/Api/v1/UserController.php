<?php


namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserCreate;
use App\Http\Requests\Api\UserUpdate;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;



class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $this->authorize('index', User::class);

        $response = new UserCollection(User::queryByRequest($request));

        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreate $request)
    {
        $user = User::create($request->validated());

        return response(new UserResource($user), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('show', $user);

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FormRequest  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdate $request, User $user)
    {
        $user->update($request->validated());

        return response(['message' => "Updated succesfully"], Response::HTTP_NO_CONTENT);
    }

    /**
     * Soft remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return response(['message' => "Deleted succesfully"], Response::HTTP_NO_CONTENT);
    }

    /**
     * Hard remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function hardDelete(User $user)
    {
        $this->authorize('hardDelete', User::class);

        $user->hardDelete();

        return response(['message' => "Deleted succesfully"], Response::HTTP_NO_CONTENT);
    }
}




