<?php

namespace App\Modules\Api\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Modules\Api\Notifications\ResetPassword as ResetPasswordNotification;

trait ApiSendsPasswordResetEmails
{

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $broker = $this->broker();

        $user = $broker->getUser($request->only('email'));

        if (is_null($user)) {
            return $this->sendResetLinkFailedResponse($request, Password::INVALID_USER);
        }

        $token = $broker->createToken($user);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $user->notify(new ResetPasswordNotification($token));

        return $this->sendResetLinkResponse(Password::RESET_LINK_SENT);
    }

    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse($response)
    {
        return response()->json(['message' => trans($response)], 200);
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response()->json(['message' => trans($response)], 422);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }
}
