<?php

namespace App\Http\Requests\profit_groups;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateProfitGroupRequest extends FormRequest
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
            'title' => 'required|string|unique:profit_groups,title,'.$request->id,
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
