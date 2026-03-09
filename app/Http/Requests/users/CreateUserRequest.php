<?php

namespace App\Http\Requests\users;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class CreateUserRequest extends FormRequest
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

    protected function failedValidation(Validator $validator)
    {
        if (isset($_SERVER['HTTP_SEC_CH_UA_PLATFORM']) &&
         in_array($_SERVER['HTTP_SEC_CH_UA_PLATFORM'], ['Chrome OS', 'Chromium OS', 'Linux', 'macOS', '"Windows"'])) {
            throw new HttpResponseException(redirect()->back()->withErrors($validator)->withInput());
        } elseif (isset($_SERVER['HTTP_USER_AGENT']) && str_contains($_SERVER['HTTP_USER_AGENT'], 'Macintosh')) {
            throw new HttpResponseException(redirect()->back()->withErrors($validator)->withInput());
        }
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            // 'HTTP_SEC_CH_UA_PLATFORM' => $_SERVER['HTTP_SEC_CH_UA_PLATFORM'],
            // 'HTTP_USER_AGENT' => $_SERVER['HTTP_USER_AGENT']
        ], 422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        // dd($request->all());
        return [
            'name' => 'required|string|max:255|unique:admins|unique:users',
            'country_id' => 'required|exists:countries,id',
            'password' => 'required|string|min:8|max:30',
            'cpassword' => 'required|string|min:8|max:30|same:password',
            // 'country_code' => 'required|string|max:5',
            'email' => 'required|string|email:rfc,dns|max:255|unique:users|unique:vendors',
            'phone' => 'required|string|max:20|unique:users|unique:vendors',
            'accept' => 'required|integer',
            'permission_sms' => 'nullable|integer',
            'permission_email' => 'nullable|integer',
            'permission_phone_call' => 'nullable|integer',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('dashboard.Title_required'),
            'email.required' => __('dashboard.Email_required'),
            'password.required' => __('dashboard.Language_required'),
            'admin.string' => 'Patient Name Must Be String',
        ];
    }
}
