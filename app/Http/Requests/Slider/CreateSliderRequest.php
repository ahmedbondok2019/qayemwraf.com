<?php

namespace App\Http\Requests\Slider;

use Illuminate\Foundation\Http\FormRequest;

class CreateSliderRequest extends FormRequest
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
            'parent_id' => 'nullable|numeric',
            'view' => 'nullable|numeric',
            //            'categories_id' => 'required|numeric',
            'slug' => 'required|string|max:1000000',
            'image' => 'required|mimes:jpeg,bmp,png,webp,jfif',
            'image1' => 'required|mimes:png',
            //            'meta_title' => 'nullable|string|max:1000',
            //            'meta_description' => 'nullable|string|max:1000',
            //            'meta_keywords' => 'nullable|string|max:1000',
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
