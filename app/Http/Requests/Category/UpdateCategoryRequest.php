<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateCategoryRequest extends FormRequest
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
        // $idFirst = $this->request->get('trans_id') ? ',' . $this->request->get('trans_id') : '';
        // $request->id == null ? $id = $idFirst : $id = ',' . $request->id;
        // $title = 'required|string|unique:category_translations,title'.$id.',deleted_at,NULL';

        return [
            // 'title' => $title,
            'view' => 'nullable',
            'parent_id' => 'nullable',
            //            'image' => 'nullable|mimes:jpeg,jpg,bmp,png,webp,jfif',
            //            'meta_title' => 'nullable|string|max:255',
            //            'meta_description' => 'nullable|string|max:255',
            //            'meta_keywords' => 'nullable|string|max:255',
        ];
    }
}
