<?php

namespace App\Modules\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListAssetRequest extends FormRequest
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
            'cryptocurrency_id' => 'required|integer|exists:cryptocurrencies,id'
        ];
    }
}
