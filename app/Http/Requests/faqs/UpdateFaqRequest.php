<?php

namespace App\Http\Requests\faqs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateFaqRequest extends FormRequest
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
            'view' => 'nullable|numeric',
            'title' => 'required|string',
            'description' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'categories_id.required' => __('validation.required'),
        ];
    }
}
