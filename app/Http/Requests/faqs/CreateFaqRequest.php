<?php

namespace App\Http\Requests\faqs;

use Illuminate\Foundation\Http\FormRequest;

class CreateFaqRequest extends FormRequest
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
            'view' => 'nullable|numeric',
            'title' => 'required|string',
            'description' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            //            'title.required' => __('dashboard.Title_required'),
            //            'image.required' => __('dashboard.Image_required'),
            //            'lang_id.required' => __('dashboard.Language_required'),
        ];
    }
}
