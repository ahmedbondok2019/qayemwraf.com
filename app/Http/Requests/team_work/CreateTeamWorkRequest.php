<?php

namespace App\Http\Requests\team_work;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CreateTeamWorkRequest extends FormRequest
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
            'title' => 'required|string|unique:team_work_translations,deleted_at',
            'idea' => 'required|string',
            'posts' => 'nullable|string',
            'sponsored' => 'nullable|string',
            'result' => 'nullable|string',
            'report' => 'nullable|string',
            'video_link' => 'nullable|string',
            'video_file' => 'nullable|mimetypes:video/mp4',
            'image.*' => 'nullable|mimes:jpeg,bmp,png,webp,jfif',
            'primary_image' => 'nullable|mimes:jpeg,bmp,png,webp,jfif',
        ];
    }

    public function messages()
    {
        return [
            'title.unique' => __('dashboard.Duplicate Title'),
            'title.required' => __('dashboard.Title_required'),
            'image.required' => __('dashboard.Image_required'),
            'lang_id.required' => __('dashboard.Language_required'),
        ];
    }
}
