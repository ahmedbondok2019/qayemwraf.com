<?php

namespace App\Http\Requests\ApiV1\Auth;

use App\Http\Requests\ApiV1\BaseApiV1Request;

class SocialLoginRequest extends BaseApiV1Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'provider' => 'required|in:google,facebook,apple',
            'provider_id' => 'required|string',
            'email' => 'nullable|email',
            'name' => 'nullable|string',
            'image' => 'nullable|string',
            'temp_user_id' => 'nullable|string',
            'country_id' => 'nullable|integer',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'provider.required' => __('يجب تحديد موفر الخدمة'),
            'provider.in' => __('موفر الخدمة غير صالح (google, facebook, apple)'),
            'provider_id.required' => __('يجب تحديد معرف موفر الخدمة'),
        ];
    }
}
