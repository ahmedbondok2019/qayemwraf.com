<?php

namespace App\Http\Requests\vendors;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateVendorRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'name' => 'required|string|unique:vendors,name,'.$request->id.',deleted_at',
            'phone' => 'required|string|unique:vendors,phone,'.$request->id.',deleted_at',
            'email' => 'required|string|unique:vendors,email,'.$request->id.',deleted_at',
            'password' => ['nullable', 'string', 'min:8', 'max:30'],
            'cpassword' => ['nullable', 'string', 'min:8', 'max:30', 'same:password'],
        ];
    }

    public function messages()
    {
        return [
            'unique' => __('validation.email exists'),
            'exists' => __('validation.email exists'),
            'required' => __('validation.title required'),
            'string' => __('validation.string'),
            'password' => __('validation.password required'),
        ];
    }
}
