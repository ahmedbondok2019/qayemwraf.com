<?php

namespace App\Http\Requests\flash_sale;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateFlashSaleRequest extends FormRequest
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
            'flash_name' => 'required|string',
            'valid_from' => 'required|string',
            'valid_to' => 'required|string',
            'primary_image' => 'nullable|mimes:jpeg,bmp,png,webp,jfif',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('validation.title required'),
        ];
    }
}
