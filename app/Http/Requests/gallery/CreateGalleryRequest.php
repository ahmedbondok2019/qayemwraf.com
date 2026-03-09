<?php

namespace App\Http\Requests\gallery;

use Illuminate\Foundation\Http\FormRequest;

class CreateGalleryRequest extends FormRequest
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
            'gallery_name' => 'required|string',
            'image.*' => 'required|mimes:jpeg,bmp,png,webp,jfif',
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
