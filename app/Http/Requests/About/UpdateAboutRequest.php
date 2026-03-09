<?php

namespace App\Http\Requests\About;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateAboutRequest extends FormRequest
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
            'photo' => 'nullable|mimes:jpeg,jpg,bmp,png,webp,jfif',
            'images.*' => 'nullable|mimes:jpeg,jpg,bmp,png,webp,jfif',
            'slug' => 'required|string',
            'mission' => 'nullable|string',
            'vision' => 'nullable|string',
            'history' => 'nullable|string',
            'description' => 'required|string',
            'video_link' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'categories_id.required' => __('validation.required'),
        ];
    }
}
