<?php

namespace AppHttpResourcesApiV1;

use IlluminateHttpRequest;
use IlluminateHttpResourcesJsonJsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $slug = $this->translation->slug ?? ($this->translations->first()->slug ?? (string) $this->id);

        return [
            'id' => $this->id,
            'title' => $this->translation->title ?? ($this->translations->first()->title ?? ''),
            'name' => $this->translation->title ?? ($this->translations->first()->title ?? ''),
            'slug' => $slug,
            'image' => $this->image ? asset(ltrim(preg_replace('#/+#', '/', $this->image), '/')) : null,
            'link' => $slug,
            'show_on_home' => (bool) ($this->show_on_home ?? true),
            'products_count' => $this->whenCounted('products'),
            'parent_id' => $this->parent_id,
            'parent' => new CategoryResource($this->whenLoaded('parent')),
            'sub_categories' => $this->relationLoaded('children') ? CategoryResource::collection($this->children) : [],
            'fixed' => false,
        ];
    }
}
