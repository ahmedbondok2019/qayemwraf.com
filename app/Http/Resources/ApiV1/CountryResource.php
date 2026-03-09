<?php

namespace App\Http\Resources\ApiV1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
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
            'name' => $this->translation->name ?? null,
            'code' => $this->code,
            'phone_code' => $this->phone_code,
            'image' => $this->image ? asset($this->image) : null,
            'is_active' => (bool)$this->is_active,
        ];
    }
}
