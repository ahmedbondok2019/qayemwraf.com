<?php

namespace App\Http\Requests\ApiV1\Wishlist;

use App\Http\Requests\ApiV1\BaseApiV1Request;

class WishlistIndexRequest extends BaseApiV1Request
{
    public function rules(): array
    {
        return [
            'temp_user_id' => auth('sanctum')->check() ? 'nullable|string' : 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'temp_user_id.required' => __('The temp user id is required for guests.'),
        ];
    }
}
