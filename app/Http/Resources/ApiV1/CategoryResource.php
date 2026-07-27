<?php

namespace App\Http\Resources\ApiV1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'title' => $this->translation->title ?? ($this->translations->first()->title ?? ''),
            'name' => $this->translation->title ?? ($this->translations->first()->title ?? ''),
            'image' => $this->image ? asset($this->image) : null,
            'link' => (string)$this->id,
            'show_on_home' => (bool)($this->show_on_home ?? true),
            'products_count' => $this->whenCounted('products'),
            'parent_id' => $this->parent_id,
            'parent' => new CategoryResource($this->whenLoaded('parent')),
            'sub_categories' => $this->relationLoaded('children') ? CategoryResource::collection($this->children) : [],
            'fixed' => false,
        ];
    }
}
