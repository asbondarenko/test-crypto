<?php

namespace App\Modules\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateRecommendationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => 'required',
            'hear_about_us' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'author_id' => 'unique_with:recommendations,user_id',
        ];
    }

    /**
     * Get all of the input and files for the request.
     *
     * @param null $keys
     * @return array
     */
    public function all($keys = null)
    {
        return array_merge(parent::all($keys), ['author_id' => Auth::id()]);
    }
}
