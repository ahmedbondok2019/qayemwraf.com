<?php

namespace AppHttpResourcesApiV1;

use AppModelsCategory;
use IlluminateHttpRequest;
use IlluminateHttpResourcesJsonJsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $offerSlug = $this->translation->slug ?? ($this->translations->first()->slug ?? (string) $this->id);

        $category = $this->relationLoaded('category') ? $this->category : null;
        if (! $category && $this->category_id) {
            $category = Category::with('translation')->find($this->category_id);
        }

        // Fallback: If category not assigned or sub-category, match category by offer name
        if (! $category) {
            $offerTitle = $this->translation->name ?? ($this->translations->first()->name ?? '');
            if ($offerTitle) {
                $cleanTitle = trim(explode('(', $offerTitle)[0]);
                $category = Category::whereHas('translations', function ($q) use ($cleanTitle) {
                    $q->where('title', 'like', '%'.$cleanTitle.'%');
                })->with('translation')->first();
            }
        }

        $categorySlug = $category ? ($category->translation->slug ?? ($category->translations->first()->slug ?? (string) $category->id)) : null;
        $targetSlug = $categorySlug ?: $offerSlug;
        $categoryLink = $targetSlug ? "/category/{$targetSlug}" : '/products';

        $customLink = $this->link;
        if ($customLink && $customLink !== 'https://qayemwraf.com' && $customLink !== 'https://qayemwraf.com/' && !str_starts_with($customLink, 'http')) {
            $finalLink = str_starts_with($customLink, '/') ? $customLink : '/' . $customLink;
        } elseif ($customLink && $customLink !== 'https://qayemwraf.com' && $customLink !== 'https://qayemwraf.com/') {
            $finalLink = $customLink;
        } else {
            $finalLink = $categoryLink;
        }

        return [
            'id' => $this->id,
            'title' => $this->translation->name ?? ($this->translations->first()->name ?? $this->name),
            'name' => $this->translation->name ?? ($this->translations->first()->name ?? $this->name),
            'description' => $this->translation->description ?? ($this->translations->first()->description ?? ''),
            'image' => $this->image ? asset($this->image) : null,
            'link' => $finalLink,
            'url' => $finalLink,
            'link_type' => $this->link_type ?? 'category',
            'link_id' => $category ? $category->id : $this->link_id,
            'category_id' => $category ? $category->id : $this->category_id,
            'category_slug' => $targetSlug,
            'category' => $category ? new CategoryResource($category) : null,
            'filters' => [
                'flash_sale' => 1,
            ],
            'is_active' => (bool) $this->is_active,
            'slug' => $offerSlug,
        ];
    }
}
