<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Base64EncodedImage implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (is_array($value)) {
            $value = array_shift($value);
        }

        return preg_match('/^(data\:image\/(png|jpeg|jpg);base64,){1}.+$/', $value); // TODO: Move extensions to some config
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The :attribute has incorrect format or mime type. Supported mime types are: image/png, image/jpg, image/jpeg');
    }
}
