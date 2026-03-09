<?php

namespace App\Http\Requests\options;

use Illuminate\Foundation\Http\FormRequest;

class CreateOptionsRequest extends FormRequest
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
            'title' => 'required|string',
            'type' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('dashboard.Title Required'),
            'type.required' => __('dashboard.Type Required'),
            'title.string' => __('dashboard.Title string'),
            'type.string' => __('dashboard.Type string'),
        ];
    }
}
