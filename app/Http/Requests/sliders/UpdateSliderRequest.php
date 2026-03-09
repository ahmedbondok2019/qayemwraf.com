<?php

namespace App\Http\Requests\sliders;

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
            //            'title' => 'required|string|unique:categories,title,' . $request->id,
            //            'view' => 'nullable',
            //            'parent_id' => 'nullable|integer',
            'title' => 'required|string',
            'link' => 'required|string',
            // 'location' => 'required|integer',
            //            'categories_id' => 'required|integer',
            //            'patient_details' => 'required|string',
            //            'image' => 'nullable|mimes:jpeg,jpg,bmp,png,webp,jfif',
            //            'meta_title' => 'nullable|string|max:255',
            //            'meta_description' => 'nullable|string|max:255',
            //            'meta_keywords' => 'nullable|string|max:255',
        ];
    }

    //    public function messages()
    //    {
    //        return [
    //          'categories_id.required' => __('validation.required')
    //        ];
    //    }
}
