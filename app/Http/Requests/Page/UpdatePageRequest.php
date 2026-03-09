<?php

namespace App\Http\Requests\Page;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdatePageRequest extends FormRequest
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
            //            'title' => 'required|string|unique:pages,' . $request->id,
            'view' => 'nullable',
            'page_id' => 'required|integer',
            'description' => 'required|string',
            //            'image' => 'nullable|mimes:jpeg,jpg,bmp,png,webp,jfif',
            //            'meta_title' => 'nullable|string|max:255',
            //            'meta_description' => 'nullable|string|max:255',
            //            'meta_keywords' => 'nullable|string|max:255',
        ];
    }

    //    public function messages()
    //    {
    //        return [
    //          'title_id.required' => __('validation.required')
    //        ];
    //    }
}
