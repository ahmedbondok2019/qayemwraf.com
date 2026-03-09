<?php

namespace App\Http\Resources\ApiV1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FlashSaleResource extends JsonResource
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
            'name' => $this->translation->name ?? ($this->translations->first()->name ?? $this->name),
            'image' => $this->image ? asset($this->image) : null,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'is_active' => (bool)$this->is_active,
            'products_count' => $this->whenCounted('products'),
            'products' => ProductResource::collection($this->whenLoaded('products')),
            // Legacy fields for Flutter
            'title' => $this->translation->name ?? ($this->translations->first()->name ?? $this->name),
            'start_date' => $this->start_at,
            'end_date' => $this->end_at,
            'status' => $this->is_active ? 1 : 0,
            'featured' => 1,
        ];
    }
}
