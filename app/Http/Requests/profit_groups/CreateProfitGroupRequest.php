<?php

namespace App\Http\Requests\profit_groups;

use Illuminate\Foundation\Http\FormRequest;

class CreateProfitGroupRequest extends FormRequest
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
            'title' => 'required|string|unique:profit_groups,name,deleted_at,id',
            'value' => 'required|string',
            'type' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('validation.title required'),
        ];
    }
}
