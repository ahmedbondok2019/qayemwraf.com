<?php

namespace App\Http\Requests\home;

use Illuminate\Foundation\Http\FormRequest;

use function __;

class NewsletterRequest extends FormRequest
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
            'newsletter_email' => 'required|string|email|max:100',
        ];
    }

    public function messages()
    {
        return [
            'contact_email.required' => __('validation.attributes.contact_email'),
        ];
    }
}
