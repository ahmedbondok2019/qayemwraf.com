<?php

namespace App\Http\Resources\ApiV1;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title, // Current locale title
            'content' => $this->content, // Current locale content
            'translations' => $this->translations->map(function ($translation) {
                return [
                    'locale' => $translation->locale,
                    'title' => $translation->title,
                    'content' => $translation->content,
                    'meta_title' => $translation->meta_title,
                    'meta_description' => $translation->meta_description,
                ];
            }),
        ];
    }
}
