<?php

namespace App\Http\Requests\About;

use Illuminate\Foundation\Http\FormRequest;

class CreateAboutTransRequest extends FormRequest
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
            'slug' => 'required|string',
            'mission' => 'nullable|string',
            'vision' => 'nullable|string',
            'history' => 'nullable|string',
            'description' => 'required|string',
            'images.*' => 'nullable|mimes:jpeg,jpg,bmp,png,webp,jfif',
            'image' => 'nullable|mimes:jpeg,jpg,bmp,png,webp,jfif',
            'video_link' => 'nullable|string',
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
