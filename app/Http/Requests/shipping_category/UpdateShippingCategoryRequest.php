<?php

namespace App\Http\Requests\shipping_category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateShippingCategoryRequest extends FormRequest
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
            // 'title' => 'required|string|unique:city_translations,title,deleted_at,' . $request->city_id,
            'title' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('validation.title required'),
        ];
    }
}
