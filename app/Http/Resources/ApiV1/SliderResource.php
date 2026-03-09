<?php

namespace App\Http\Resources\ApiV1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
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
            'image' => $this->image ? asset($this->image) : null,
            'link_type' => $this->link_type,
            'link_id' => $this->link_id,
            'title' => $this->translation->title ?? '',
            'description' => $this->translation->description ?? '',
            'category' => $this->category ? [
                'id' => $this->category->id,
                'name' => $this->category->name,
            ] : null,
            'sort_order' => $this->sort_order,
            // Legacy fields for Flutter
            'link' => $this->link_id ? (string)$this->link_id : '',
            'category_id' => $this->category ? $this->category->id : null,
            'category_title' => $this->category ? ($this->category->translation->title ?? '') : '',
            'type' => $this->link_type ?? 'category',
        ];
    }
}
