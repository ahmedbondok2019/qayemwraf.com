<?php

namespace App\Http\Requests\ApiV1\Address;

use App\Http\Requests\ApiV1\BaseApiV1Request;

class AddressUpdateRequest extends BaseApiV1Request
{
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'country_id' => 'nullable|exists:countries,id',
            'governorate_id' => 'nullable|exists:governorates,id',
            'city_id' => 'nullable|exists:cities,id',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'lat' => 'nullable|string',
            'lng' => 'nullable|string',
            'is_main' => 'nullable|boolean',
        ];
    }
}
