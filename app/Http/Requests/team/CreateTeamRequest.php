<?php

namespace App\Http\Requests\team;

use Illuminate\Foundation\Http\FormRequest;

class CreateTeamRequest extends FormRequest
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
            'team_name' => 'required|string',
            'member_type' => 'required|string',
            'team_description' => 'nullable|string',
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
