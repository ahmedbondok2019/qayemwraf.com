<?php

namespace App\Http\Requests\ApiV1\Auth;

use App\Http\Requests\ApiV1\BaseApiV1Request;

class LoginRequest extends BaseApiV1Request
{
    public function rules(): array
    {
        return [
            'login' => 'required|string',
            'password' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'login.required' => __('The login field is required.'),
            'password.required' => __('The password field is required.'),
        ];
    }
}
