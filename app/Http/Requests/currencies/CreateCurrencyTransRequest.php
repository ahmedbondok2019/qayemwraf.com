<?php

namespace App\Http\Requests\currencies;

use Illuminate\Foundation\Http\FormRequest;

class CreateCurrencyTransRequest extends FormRequest
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
            'name' => 'required|string|unique:currency_translations,name,deleted_at,id',
            'slug' => 'required|string',
            'rate' => 'required|string',
            'currency_sign' => 'required|string',
            'status' => 'required|string',
            // 'image' => 'required|mimes:jpeg,bmp,png,webp,jfif',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('validation.title required'),
        ];
    }
}
