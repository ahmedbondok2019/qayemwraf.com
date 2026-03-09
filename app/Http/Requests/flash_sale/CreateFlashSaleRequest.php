<?php

namespace App\Http\Requests\flash_sale;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateFlashSaleRequest extends FormRequest
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
    public function rules()
    {
        return [
            // 'title' => 'required|string|unique:city_translations,title,deleted_at,id',
            'flash_name' => 'required|string|'.Rule::unique('flash_sales')->whereNull('deleted_at'),
            'valid_from' => 'required|string',
            'valid_to' => 'required|string',
            'primary_image' => 'required|mimes:jpeg,bmp,png,webp,jfif',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('validation.title required'),
        ];
    }
}
