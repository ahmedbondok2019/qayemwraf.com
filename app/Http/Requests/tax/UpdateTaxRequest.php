<?php

namespace App\Http\Requests\tax;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateTaxRequest extends FormRequest
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
            'title' => 'required|string|unique:taxes,title,'.$request->id,
            'value' => 'required|string',
            'status' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('validation.title required'),
            'value.required' => __('validation.value required'),
            'status.required' => __('validation.status required'),
        ];
    }
}
