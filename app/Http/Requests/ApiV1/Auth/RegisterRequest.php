<?php

namespace App\Http\Requests\ApiV1\Auth;

use App\Http\Requests\ApiV1\BaseApiV1Request;

class RegisterRequest extends BaseApiV1Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|unique:users',
            'country_id' => 'required|exists:countries,id',
            'password' => 'required|string|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('The name field is required.'),
            'email.required' => __('The email field is required.'),
            'email.email' => __('The email must be a valid email address.'),
            'email.unique' => __('The email has already been taken.'),
            'phone.required' => __('The phone field is required.'),
            'phone.unique' => __('The phone has already been taken.'),
            'country_id.required' => __('The country field is required.'),
            'country_id.exists' => __('The selected country is invalid.'),
            'password.required' => __('The password field is required.'),
            'password.min' => __('The password must be at least 6 characters.'),
        ];
    }
}
