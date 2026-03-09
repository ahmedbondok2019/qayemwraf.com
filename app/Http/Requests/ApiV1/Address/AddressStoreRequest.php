<?php

namespace App\Http\Requests\ApiV1\Address;

use App\Http\Requests\ApiV1\BaseApiV1Request;

class AddressStoreRequest extends BaseApiV1Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'governorate_id' => 'required|exists:governorates,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string',
            'phone' => 'required|string',
            'lat' => 'nullable|string',
            'lng' => 'nullable|string',
            'is_main' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('The name field is required.'),
            'country_id.required' => __('The country field is required.'),
            'governorate_id.required' => __('The governorate field is required.'),
            'city_id.required' => __('The city field is required.'),
            'address.required' => __('The address field is required.'),
            'phone.required' => __('The phone field is required.'),
        ];
    }
}
