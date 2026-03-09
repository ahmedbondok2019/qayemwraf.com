<?php

namespace App\Http\Requests\currencies;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateCurrencyRequest extends FormRequest
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
            'name' => 'required|string|unique:currency_translations,name,'.$request->currency_id.',deleted_at',
            'image' => 'nullable|mimes:jpeg,bmp,png,webp,jfif',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('validation.name required'),
        ];
    }
}
