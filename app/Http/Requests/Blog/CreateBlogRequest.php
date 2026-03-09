<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class CreateBlogRequest extends FormRequest
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
            'title' => 'required|string|unique:blog_translations,title,deleted_at,id',
            'parent_id' => 'nullable|numeric',
            'view' => 'nullable|numeric',
            'slug' => 'required|String|max:100',
            'description' => 'required|string|max:1000000',
            'image' => 'required|mimes:jpeg,bmp,png,webp,jfif',
            'meta_title' => 'nullable|string|max:1000',
            'meta_description' => 'nullable|string|max:1000',
            'meta_keywords' => 'nullable|string|max:1000',
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
