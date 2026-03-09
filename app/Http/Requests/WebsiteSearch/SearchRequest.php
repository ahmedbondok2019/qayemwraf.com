<?php

namespace App\Http\Requests\WebsiteSearch;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
            'keyword' => 'required|string|max:255',
        ];
    }

    //    public function messages()
    //    {
    //        return [
    //            'keyword.required' => __('validation.key_word_required'),
    //            'keyword.string' => __('validation.key_word_string'),
    //        ];
    //    }
}
