<?php

namespace App\Http\Resources\ApiV1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogCategoryResource extends JsonResource
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
            'title' => $this->translation->title ?? '',
            'image' => $this->image ? asset('uploads/blog_categories/' . $this->image) : null,
            'blogs_count' => $this->blogs_count,
        ];
    }
}
