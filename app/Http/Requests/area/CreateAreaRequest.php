<?php

namespace App\Http\Requests\area;

use Illuminate\Foundation\Http\FormRequest;

class CreateAreaRequest extends FormRequest
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
            'title' => 'required|string|unique:area_translations,title,deleted_at,id',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('validation.title required'),
        ];
    }
}
