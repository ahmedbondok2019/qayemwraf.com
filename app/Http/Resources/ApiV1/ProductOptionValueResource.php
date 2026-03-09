<?php

namespace App\Http\Resources\ApiV1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductOptionValueResource extends JsonResource
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
            'option_value_id' => $this->option_value_id,
            'value_name' => $this->optionValue ? $this->optionValue->value : null,
            'quantity' => (int)$this->quantity,
            'subtract_stock' => (bool)$this->subtract_stock,
            'price' => (float)$this->price,
            'price_increment' => (bool)$this->price_increment,
            'weight' => (float)$this->weight,
            'weight_increment' => (bool)$this->weight_increment,
            // Legacy fields for Flutter
            'title' => $this->optionValue ? $this->optionValue->value : null,
            'difference_in_price' => (int)$this->price,
            'difference_in_weight' => (int)$this->weight,
            'ignore_quantity' => false,
            'isPluse' => (bool)$this->price_increment,
            'isMinus' => !(bool)$this->price_increment,
        ];
    }
}
