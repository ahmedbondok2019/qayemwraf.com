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
        $now = now();
        $remainingSeconds = max(0, $this->end_at ? $now->diffInSeconds($this->end_at, false) : 0);

        return [
            'id' => $this->id,
            'title' => $this->translation->name ?? ($this->translations->first()->name ?? $this->name),
            'name' => $this->translation->name ?? ($this->translations->first()->name ?? $this->name),
            'image' => $this->image ? asset($this->image) : null,
            'start_at' => $this->start_at ? $this->start_at->toDateTimeString() : null,
            'end_at' => $this->end_at ? $this->end_at->toDateTimeString() : null,
            'remaining_seconds' => (int)$remainingSeconds,
            'is_active' => (bool)$this->is_active,
            'products_count' => $this->relationLoaded('products') ? $this->products->count() : ($this->whenCounted('products') ?? 0),
            'products' => ProductResource::collection($this->whenLoaded('products')),
            // Legacy fields for Flutter
            'start_date' => $this->start_at ? $this->start_at->toDateTimeString() : null,
            'end_date' => $this->end_at ? $this->end_at->toDateTimeString() : null,
            'status' => $this->is_active ? 1 : 0,
            'featured' => 1,
        ];
    }
}
