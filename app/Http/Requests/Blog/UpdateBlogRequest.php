<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateBlogRequest extends FormRequest
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
            'title' => 'required|string',
            'view' => 'nullable',
            //            'parent_id' => 'nullable|numeric',
            'blog_id' => 'required|numeric',
            //            'categories_id' => 'required|numeric',
            'description' => 'required|string',
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
