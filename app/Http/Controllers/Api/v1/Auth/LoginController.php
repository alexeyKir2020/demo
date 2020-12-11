<?php


namespace App\Http\Controllers\Api\v1\Auth;

use App\Helpers\RoleChecker;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUser;
use App\Http\Requests\Auth\RegisterUser;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class LoginController extends Controller
{
    /*
     |--------------------------------------------------------------------------
     | Login Controller
     |--------------------------------------------------------------------------
     |
     | This controller handles authenticating users for the application and
     | redirecting them to your home screen. The controller uses a trait
     | to conveniently provide its functionality to your applications.
     |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $account = "/account";
    protected $admin = "/admin";

    public function login(LoginUser $request)
    {
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        try {

            $token = $this->getToken($request->validated());

            return $request->wantsJson()
                ? response(["access_token" => $token], Response::HTTP_OK)
                : redirect(RoleChecker::isAdmin() ? $this->admin : $this->account);

        } catch (AuthorizationException $e) {
            return response(["message" => $e->getMessage()], $e->getCode());
        }
    }

    public function getToken($request)
    {
        if (Auth::attempt(['email' => $request['username'], 'password' => $request['password']])) {

            if(!(Auth::user()->isSuspended()))
                return Auth::user()->createToken('access_token')->plainTextToken;

            throw new AuthorizationException(
                'Account suspended',
                Response::HTTP_FORBIDDEN
            );
        }

        throw new AuthorizationException(
            'Account with this combination of credentials not found',
            Response::HTTP_UNAUTHORIZED
        );
    }

    public function logout(Request $request)
    {
        if(Auth::user()) {
            $request->user()->currentAccessToken()->delete();

            return $request->wantsJson()
                ? new JsonResponse([], Response::HTTP_NO_CONTENT)
                : redirect('/');
        }

        return $request->wantsJson()
            ? new JsonResponse(['Unauthanticated.'], Response::HTTP_UNAUTHORIZED)
            : redirect('/');
    }

}
