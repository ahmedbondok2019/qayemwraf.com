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
            'title' => $this->translation->name ?? ($this->translations->first()->name ?? $this->name),
            'name' => $this->translation->name ?? ($this->translations->first()->name ?? $this->name),
            'description' => $this->translation->description ?? ($this->translations->first()->description ?? ''),
            'image' => $this->image ? asset($this->image) : null,
            'link' => $this->link_id ? (string)$this->link_id : '',
            'link_type' => $this->link_type ?? 'category',
            'link_id' => $this->link_id,
            'category_id' => $this->category_id,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'filters' => [
                'flash_sale' => 1
            ],
            'is_active' => (bool)$this->is_active,
            'slug' => (string)$this->id,
        ];
    }
}
