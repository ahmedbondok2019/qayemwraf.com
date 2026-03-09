<?php

namespace App\Http\Requests\ApiV1\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'address_id' => 'nullable|exists:user_addresses,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'coupon_code' => 'nullable|string',
            'services' => 'nullable|array',
            'services.*' => 'exists:order_services,id',
            'note' => 'nullable|string|max:500',
            'temp_user_id' => 'nullable|string',
        ];
    }
}
