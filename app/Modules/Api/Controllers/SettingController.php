<?php

namespace App\Modules\Api\Controllers;


class SettingController extends ApiController
{
    /**
     * Return application terms and conditions.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function termsAndConditions()
    {
        return response()->json(['terms_and_conditions' => setting('terms_and_conditions')], 200);
    }
}