<?php

namespace App\Http\Requests\users;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        // $data = json_decode($request->getContent());
        // $requestArray = [
        //     'name' => $data->name, 'phone' => $data->phone , 'email' => $data->email ,
        //     'oldpassword' => $data->oldpassword , 'password' => $data->password,
        //     'cpassword' => $data->cpassword , 'permission_sms' => $data->permission_sms,
        //     'permission_email' => $data->permission_email , 'permission_phone_call' => $data->permission_phone_call,
        // ];
        // $request->merge(json_decode($request->getContent(), true));

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email:rfc,dns|max:255|unique:vendors|'.Rule::unique('users')->ignore(Auth::id()),
            'phone' => 'required|string|starts_with:015,010,011,012,00966,966|digits:11|unique:vendors|'.Rule::unique('users')->ignore(Auth::id()),
            'password' => 'string|min:8|max:30|nullable',
            'oldpassword' => 'nullable|string|min:8|max:30',
            'cpassword' => 'string|min:8|max:30|same:password|nullable',
            'permission_sms' => 'nullable|integer',
            'permission_email' => 'nullable|integer',
            'permission_phone_call' => 'nullable|integer',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('validation.required'),
            'email.required' => __('validation.required'),
            'phone.required' => __('validation.required'),
            'oldpassword.required' => __('validation.required'),
            'password.required' => __('validation.required'),
            'cpassword.required' => __('validation.required'),
            'permission_sms.required' => __('validation.required'),
            'permission_email.required' => __('validation.required'),
            'permission_phone_call.required' => __('validation.required'),
        ];
    }
}
