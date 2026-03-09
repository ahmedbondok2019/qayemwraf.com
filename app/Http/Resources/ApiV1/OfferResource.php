<?php

namespace App\Http\Resources\ApiV1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
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
            'image' => $this->image ? asset($this->image) : null,
            'link_type' => $this->link_type,
            'link_id' => $this->link_id,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'filters' => [
                'flash_sale' => 1
            ],
            'is_active' => $this->is_active,
            // Legacy fields for Flutter
            'title' => $this->name,
            'slug' => (string)$this->id, // fallback to ID if slug is missing
        ];
    }
}
