<?php

namespace App\Http\Resources\ApiV1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();
        
        return [
            'id' => $this->id,
            'name' => $locale === 'ar' ? ($this->name_ar ?? $this->name) : ($this->name ?? $this->name_ar),
            'price' => (float)$this->price,
            'is_active' => (bool)$this->is_active,
        ];
    }
}
