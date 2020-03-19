<?php

namespace App\Modules\Api\Controllers\Auth;

use App\Modules\Api\Controllers\ApiController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\DB;

class LoginController extends ApiController
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
    protected $redirectTo = '/home';


    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string|exists:users,email',
            'password' => 'required|string',
        ]);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        $client = Client::where('password_client', 1)->firstOrFail();

        $data = request()->only('email','password');

        $request->request->add([
            'grant_type'    => 'password',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'username'      => $data['email'],
            'password'      => $data['password'],
            'scope'         => '*',
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        return \Route::dispatch($proxy);

//        if ($this->attemptLogin($request)) {
//            $user = $this->guard()->user();
//            $user->generateToken();
//
//            return response()->json($user->toArray());
//        }

//        return $this->sendFailedLoginResponse($request);
    }

    public function social(Request $request)
    {
        $this->validate($request, [
            'provider' => 'required|string',
            'access_token' => 'required|string',
        ]);

        $client = Client::where('personal_access_client', 1)->firstOrFail();

        $data = request()->only('provider','access_token');

        $request->request->add([
            'grant_type'    => 'social',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'provider'      => $data['provider'],
            'access_token'  => $data['access_token'],
            'scope'         => '*',
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        return \Route::dispatch($proxy);
    }


    public function refreshToken(Request $request)
    {
        $this->validate($request, [
            'refresh_token' => 'required|string'
        ]);

        $client = Client::where('password_client', 1)->firstOrFail();

        $data = request()->only('refresh_token');

        $request->request->add([
            'grant_type'    => 'refresh_token',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'refresh_token' => $data['refresh_token'],
            'scope'         => '*',
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        return \Route::dispatch($proxy);
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $accessToken = Auth::user()->token();
            DB::table('oauth_refresh_tokens')
                ->where('access_token_id', $accessToken->id)
                ->update([
                    'revoked' => true
                ]);

            $accessToken->revoke();
        }

        return response()->json(null, 204);
    }
}
