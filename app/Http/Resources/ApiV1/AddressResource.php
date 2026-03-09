<?php

namespace App\Http\Resources\ApiV1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'is_main' => (bool)$this->is_main,
            'country' => [
                'id' => $this->country_id,
                'name' => $this->country_rel->name ?? null,
            ],
            'governorate' => [
                'id' => $this->governorate_id,
                'name' => $this->governorate_rel->name ?? null,
            ],
            'city' => [
                'id' => $this->city_id,
                'name' => $this->city_rel->name ?? null,
            ],
        ];
    }
}
