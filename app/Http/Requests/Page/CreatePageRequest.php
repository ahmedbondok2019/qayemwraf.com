<?php

namespace App\Http\Requests\Page;

use Illuminate\Foundation\Http\FormRequest;

class CreatePageRequest extends FormRequest
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
            //            'title' => 'required|string|unique:page_Translations',
            'view' => 'nullable|integer',
            //            'image' => 'required|mimes:jpeg,bmp,png,webp,jfif',
            //            'meta_title' => 'nullable|string|max:255',
            //            'meta_description' => 'nullable|string|max:255',
            //            'meta_keywords' => 'nullable|string|max:255',
        ];
    }

    //    public function messages()
    //    {
    //        return [
    //            'title.required' => __('dashboard.Title_required'),
    //            'image.required' => __('dashboard.Image_required'),
    //            'lang_id.required' => __('dashboard.Language_required'),
    //        ];
    //    }
}
