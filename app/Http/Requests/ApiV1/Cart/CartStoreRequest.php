<?php

namespace App\Http\Requests\ApiV1\Cart;

use App\Http\Requests\ApiV1\BaseApiV1Request;

class CartStoreRequest extends BaseApiV1Request
{
    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
            'temp_user_id' => auth('sanctum')->check() ? 'nullable|string' : 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => __('The product id field is required.'),
            'product_id.exists' => __('The selected product is invalid.'),
            'temp_user_id.required' => __('The temp user id is required for guests.'),
        ];
    }
}
