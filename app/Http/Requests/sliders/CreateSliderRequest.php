<?php

namespace App\Http\Requests\sliders;

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
            'title' => 'required|string',
            'link' => 'required|string',
            // 'location' => 'required|integer',
            'image' => 'required|mimes:jpeg,bmp,png,webp,jfif',
        ];
    }

    //    public function messages()
    //    {
    //        return [
    // //            'title.required' => __('dashboard.Title_required'),
    // //            'image.required' => __('dashboard.Image_required'),
    //            'patient_name.required' => __('dashboard.Language_required'),
    //            'patient_name.string' => 'Patient Name Must Be String',
    //            'mobile_number.required' => __('dashboard.Language_required'),
    //            'mobile_number.integer' => 'mobile number Must Be integer',
    //            'mobile_number.max' => 'mobile number max Must Be 20',
    //        ];
    //    }
}
