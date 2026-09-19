<?php

namespace App\Http\Resources\ApiV1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'description' => $this->translation->description ?? ($this->translations->first()->description ?? ''),
            'image' => $this->image ? asset($this->image) : null,
            'video' => $this->video,
            'link' => $this->link,
            'sort_order' => $this->sort_order,
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d') : null,
        ];
    }
}
