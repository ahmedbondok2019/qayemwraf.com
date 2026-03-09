<?php

namespace App\Http\Resources\ApiV1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductOptionResource extends JsonResource
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
            'option_id' => $this->option_id,
            'name' => $this->option ? $this->option->name : null,
            'type' => $this->option ? $this->option->type : null,
            'required' => (bool)$this->required,
            'values' => ProductOptionValueResource::collection($this->relationLoaded('values') ? $this->values : collect([])),
            // Legacy fields for Flutter
            'title' => $this->option ? $this->option->name : null,
            'isRequired' => (bool)$this->required,
            'items' => ProductOptionValueResource::collection($this->relationLoaded('values') ? $this->values : collect([])),
        ];
    }
}
