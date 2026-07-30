<?php

namespace App\Http\Requests\ApiV1\Checkout;

use App\Http\Requests\ApiV1\BaseApiV1Request;

class CheckoutStoreRequest extends BaseApiV1Request
{
    public function authorize(): bool
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
