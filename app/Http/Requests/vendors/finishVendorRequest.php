<?php

namespace App\Http\Requests\vendors;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class finishVendorRequest extends FormRequest
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
        // dd($request->all());
        return [
            'account_type' => 'required|string',
            'profit_group' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'account_type.required' => __('validation.account_type required'),
            'profit_group.required' => __('validation.profit_group required'),
            'account_type.string' => __('validation.account_type string'),
            'profit_group.string' => __('validation.profit_group string'),
        ];
    }
}
