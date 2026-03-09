<?php

namespace App\Http\Requests\vendors;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;

class AdminCreateVendorRequest extends FormRequest
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
        $data = Session::get('types');
        if (! empty($data['account_type'])) {
            Arr::add($request->all(), 'account_type', $data['account_type']);
            Arr::add($request->all(), 'profit_group', $data['profit_group']);
        }

        return [
            // 'account_type' => 'required|string',
            // 'profit_group' => 'required|string',
            'name' => 'required|string|max:255|unique:vendors',
            'email' => 'required|string|email|max:255|unique:vendors',
            'phone' => 'required|string|max:255|unique:vendors',
            'password' => 'required|string|min:8|max:30',
        ];
    }

    public function messages()
    {
        return [
            'unique' => __('validation.exists'),
            'exists' => __('validation.exists'),
            'required' => __('validation.title required'),
            'string' => __('validation.string'),
            'password' => __('validation.password required'),
            'password' => __('validation.password min'),
        ];
    }
}
