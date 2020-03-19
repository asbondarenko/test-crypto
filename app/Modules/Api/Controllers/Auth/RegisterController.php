<?php

namespace App\Modules\Api\Controllers\Auth;

use App\Modules\Api\Controllers\ApiController;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Client;
use App\Rules\UserName;
use Illuminate\Validation\Rule;

class RegisterController extends ApiController
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

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $user = Auth::user();
        
        return Validator::make($data, [
            'email' => 'required|string|email:dns|max:255|unique:users',
            'password' => 'required|string|min:8|max:25|confirmed',
            'name' => [
                'required',
                'string',
                'min:4',
                'max:25',
                new UserName(),
                Rule::unique('users')->ignore((isset($user->id) ? $user->id : null))
            ],
            'hear_about_us' => 'string|max:255',
            'terms_and_conditions' => 'required|in:' . User::TERMS_AND_CONDITIONS_ACCEPTED
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'name' => $data['name'],
            'hear_about_us' => isset($data['hear_about_us']) ? $data['hear_about_us'] : null,
            'terms_and_conditions' => $data['terms_and_conditions']
        ]);

        return $user;
    }

    public function register(Request $request)
    {
        // Here the request is validated. The validator method is located
        // inside the RegisterController, and makes sure the name, email
        // password and password_confirmation fields are required.
        $this->validator($request->all())->validate();

        // A Registered event is created and will trigger any relevant
        // observers, such as sending a confirmation email or any
        // code that needs to be run as soon as the user is created.
        event(new Registered($user = $this->create($request->all())));

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

    }
}
