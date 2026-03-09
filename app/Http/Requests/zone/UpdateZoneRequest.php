<?php

namespace App\Http\Requests\zone;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateZoneRequest extends FormRequest
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
            'title' => 'required|string|unique:zone_translations,title,deleted_at,'.$request->zone_id,
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('validation.title required'),
        ];
    }
}
