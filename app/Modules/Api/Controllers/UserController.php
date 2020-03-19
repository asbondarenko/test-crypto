<?php

namespace App\Modules\Api\Controllers;

use App\Helpers\FileHelper;
use App\Models\Cryptocurrency;
use App\Models\Role;
use App\Models\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Services\UploadService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use App\Rules\UserName;
use App\Rules\Base64EncodedImage;
use Illuminate\Validation\Rule;

class UserController extends ApiController
{

    /**
     * @var UploadService
     */
    protected $uploadService;

    /**
     * Create a new controller instance.
     *
     * @param  UploadService $uploadService
     * @return void
     */
    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $user = Auth::user();
        $validator =  Validator::make($data, [
            'email' => [
                'sometimes',
                'required',
                'string',
                'email:dns',
                'max:255',
                Rule::unique('users')->ignore((isset($user->id) ? $user->id : null)),
            ],
            'password' => 'sometimes|nullable|string|required|min:8|max:25|confirmed', // TODO: Move password size to some config
            'name' => [ // TODO: Move name size to config
                'sometimes',
                'required',
                'string',
                'min:4',
                'max:25',
                new UserName(),
                Rule::unique('users')->ignore((isset($user->id) ? $user->id : null)),
            ],
            'hear_about_us' => 'string|nullable|max:255',
            'motto' => 'string|nullable|max:255',
            'about_me' => 'string|nullable|max:2000',
            'email_alerts' => 'string|nullable|email:dns|max:255',
            'sms_alerts' => 'string|nullable|max:255',
            'web_notifications' => 'integer|in:' . User::WEB_NOTIFICATIONS_DISABLED . ',' . User::TERMS_AND_CONDITIONS_ACCEPTED,
            'terms_and_conditions' => 'sometimes|in:' . User::TERMS_AND_CONDITIONS_ACCEPTED,
            'avatar' => [  // TODO: Add file size validation (300 kb)
                'array'
            ],
            'landscape' => [ // TODO: Add file size validation (2 mb)
                'array'
            ],
            'cryptocurrencies' => 'array'
        ]);

        $validator->sometimes('avatar', new Base64EncodedImage(), function ($input) {
            return !empty($input->avatar);
        });

        $validator->sometimes('landscape', new Base64EncodedImage(), function ($input) {
            return !empty($input->avatar);
        });

        return $validator;
    }

    /**
     * Update user profile.
     *
     * @param  Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        $data = $request->all();

        $this->validator($data)->validate();
        $user = Auth::user();

        $cryptocurrencies = $request->get('cryptocurrencies');
        if (is_array($cryptocurrencies)) {
            foreach ($cryptocurrencies as $id) {
                $cryptocurrency = Cryptocurrency::findOrFail($id);
            }

            $user->cryptocurrencies()->sync($cryptocurrencies);
        }

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        // Upload user avatar
        $this->uploadService->base64UploadAvatar($request, $user);
        // Upload user landscape
        $this->uploadService->base64UploadLandscape($request, $user);

        return new UserResource($user);
    }



    /**
     * Determine if user is authenticated.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticated()
    {
        $user = Auth::user();
        return new UserResource($user);
    }
}
