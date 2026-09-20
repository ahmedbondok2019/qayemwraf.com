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
            'image' => $this->formatImageUrl($this->image),
            'video' => $this->video,
            'link' => $this->link,
            'sort_order' => (int) $this->sort_order,
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d') : null,
        ];
    }

    protected function formatImageUrl($imagePath): ?string
    {
        if (empty($imagePath)) {
            return null;
        }

        if (str_starts_with($imagePath, 'http://') || str_starts_with($imagePath, 'https://')) {
            return $imagePath;
        }

        $cleanPath = ltrim(preg_replace('#/+#', '/', $imagePath), '/');

        return asset($cleanPath);
    }
}
