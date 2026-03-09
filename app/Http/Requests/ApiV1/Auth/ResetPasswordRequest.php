<?php

namespace App\Http\Requests\ApiV1\Auth;

use App\Http\Requests\ApiV1\BaseApiV1Request;

class ResetPasswordRequest extends BaseApiV1Request
{
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|exists:users,email',
            'otp' => 'required|string',
            'password' => 'required|string|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => __('The email field is required.'),
            'email.email' => __('The email must be a valid email address.'),
            'email.exists' => __('The selected email is invalid.'),
            'otp.required' => __('The otp field is required.'),
            'password.required' => __('The password field is required.'),
            'password.min' => __('The password must be at least 6 characters.'),
        ];
    }
}
