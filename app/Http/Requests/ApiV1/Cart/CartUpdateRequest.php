<?php

namespace App\Http\Requests\ApiV1\Cart;

use App\Http\Requests\ApiV1\BaseApiV1Request;

class CartUpdateRequest extends BaseApiV1Request
{
    public function rules(): array
    {
        return [
            'quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'quantity.required' => __('The quantity field is required.'),
            'quantity.min' => __('The quantity must be at least 1.'),
        ];
    }
}
