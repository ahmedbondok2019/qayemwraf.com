<?php

namespace App\Http\Requests\home;

use App\Rules\ReCaptcha;
use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest
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
            'contact_name' => 'required|string|max:100',
            'contact_email' => 'required|string|email|max:100',
            'contact_message' => 'required|string|max:1000',
            //            'g_recaptcha_response' => 'required|recaptcha',
            'g_recaptcha_response' => ['required', new ReCaptcha],
        ];
    }

    public function messages()
    {
        return [
            'contact_name.required' => __('validation.attributes.contact_name'),
            'contact_email.required' => __('validation.attributes.contact_email'),
            'contact_Subject.required' => __('validation.attributes.contact_Subject'),
            'contact_msg.required' => __('validation.attributes.contact_msg'),
        ];
    }
}
