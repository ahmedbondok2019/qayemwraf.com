<?php

namespace App\Http\Requests\offers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateOfferRequest extends FormRequest
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
            'title' => 'required|string|unique:offer_translations,title,'.$request->offer_id.',deleted_at',
            'image' => 'nullable|mimes:jpeg,bmp,png,webp,jfif,avif,webp',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('validation.title required'),
        ];
    }
}
