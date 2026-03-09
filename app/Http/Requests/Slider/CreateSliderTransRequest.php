<?php

namespace App\Http\Requests\Slider;

use Illuminate\Foundation\Http\FormRequest;

class CreateSliderTransRequest extends FormRequest
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
            //            'lang_id' => 'required|string',
            'title' => 'required|string|unique:slider_translations,deleted_at,NULL',
            //            'parent_id' => 'nullable|numeric',
            'slider_id' => 'required|numeric',
            //            'categories_id' => 'nullable|numeric',
            'slug' => 'required|string|max:1000000',
            'image' => 'nullable|mimes:jpeg,bmp,png,webp,jfif',
            'image1' => 'nullable|mimes:png',
            //            'image' => 'required|mimes:jpeg,bmp,png,webp,jfif',
            //            'meta_title' => 'nullable|string|max:255',
            //            'meta_description' => 'nullable|string|max:255',
            //            'meta_keywords' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            //            'title.required' => __('dashboard.Title_required'),
            //            'image.required' => __('dashboard.Image_required'),
            'lang_id.required' => __('dashboard.Language_required'),
        ];
    }
}
