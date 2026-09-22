<?php

namespace App\Http\Resources\ApiV1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $cardImage = $this->BlogTranslation->card_image ?? $this->BlogTranslation->image ?? null;
        $innerImage = $this->BlogTranslation->inner_image ?? $this->BlogTranslation->image ?? null;

        return [
            'id' => $this->id,
            'title' => $this->BlogTranslation->title ?? '',
            'description' => $this->BlogTranslation->description ?? '',
            'image' => $cardImage ? asset($cardImage) : null,
            'card_image' => $cardImage ? asset($cardImage) : null,
            'inner_image' => $innerImage ? asset($innerImage) : null,
            'slug' => $this->BlogTranslation->slug ?? '',
            'tags' => $this->BlogTranslation->tags ?? '',
            'meta_title' => $this->BlogTranslation->meta_title ?? '',
            'meta_description' => $this->BlogTranslation->meta_description ?? '',
            'meta_keywords' => $this->BlogTranslation->meta_keywords ?? '',
            'Author' => $this->BlogTranslation->Author ?? '',
            'created_at' => $this->created_at->format('Y-m-d'),
            'category' => new BlogCategoryResource($this->whenLoaded('category')),
        ];
    }
}
