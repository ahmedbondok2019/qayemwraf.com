<?php

namespace App\Http\Requests\ApiV1\Auth;

use App\Http\Requests\ApiV1\BaseApiV1Request;

class ForgetPasswordRequest extends BaseApiV1Request
{
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|exists:users,email',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => __('The email field is required.'),
            'email.email' => __('The email must be a valid email address.'),
            'email.exists' => __('البريد الإلكتروني غير مسجل لدينا'),
        ];
    }
}
