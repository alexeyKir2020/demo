<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUser;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    use VerifiesEmails;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = "/account/after-register";
    protected $account = "/account";
    protected $admin = "/admin";

    public function register(RegisterUser $request)
    {
        event(new Registered($user = User::create($request->validated())));

        $this->guard()->login($user);

        $token = Auth::user()->createToken('access_token')->plainTextToken;

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse(["data" => Auth::user(), "access_token" => $token], Response::HTTP_CREATED)
            : redirect($this->redirectPath());
    }

    public function verify(Request $request)
    {
        $user = User::query()->find($request->route('id'));

        auth()->login($user);

        if ($request->user()->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect($this->redirectPath())->with('verified', true);
    }
}
