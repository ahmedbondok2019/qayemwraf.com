<?php

namespace App\Http\Requests\Slider;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateSliderRequest extends FormRequest
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
            'title' => 'required|string|unique:slider_translations,NULL,id,deleted_at,NULL',
            'view' => 'nullable',
            //            'parent_id' => 'nullable|numeric',
            'slider_id' => 'required|numeric',
            //            'categories_id' => 'required|numeric',
            'slug' => 'required|string|max:1000000',
            'image' => 'nullable|mimes:jpeg,bmp,png,webp,jfif',
            'image1' => 'nullable|mimes:png',
            //            'image' => 'nullable|mimes:jpeg,jpg,bmp,png,webp,jfif',
            //            'meta_title' => 'nullable|string|max:255',
            //            'meta_description' => 'nullable|string|max:255',
            //            'meta_keywords' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'categories_id.required' => __('validation.required'),
        ];
    }
}
