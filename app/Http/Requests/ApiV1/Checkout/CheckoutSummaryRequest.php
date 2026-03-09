<?php

namespace App\Http\Requests\ApiV1\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutSummaryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'address_id' => 'nullable|exists:user_addresses,id',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'coupon_code' => 'nullable|string',
            'services' => 'nullable|array',
            'services.*' => 'exists:order_services,id',
            'temp_user_id' => 'nullable|string',
        ];
    }
}
