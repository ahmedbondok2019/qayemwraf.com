<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class address extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name ?? '',
            'phone' => $this->phone ?? '',
            'country' => [
                'id' => $this->country_id,
                'name' => $this->country_rel->name ?? '',
            ],
            'governorate' => [
                'id' => $this->governorate_id,
                'name' => $this->governorate_rel->name ?? '',
            ],
            'city' => [
                'id' => $this->city_id,
                'name' => $this->city_rel->name ?? '',
            ],
            'address' => $this->address ?? '',
            'lat' => $this->lat ?? '',
            'lng' => $this->lng ?? '',
            'is_main' => (bool) $this->is_main,
        ];
        //        return parent::toArray($request);
    }
}
