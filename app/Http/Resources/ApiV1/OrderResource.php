<?php

namespace App\Http\Resources\ApiV1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'order_number' => '#' . $this->id, // Simple order number for now
            'status' => $this->status,
            'status_text' => $this->getOrderStatusAttribute(),
            'total' => (float)$this->total,
            'subtotal' => (float)$this->subtotal,
            'discount' => (float)$this->discount,
            'shipping_cost' => (float)$this->shipping_cost,
            'tax' => (float)$this->tax,
            'payment_method' => $this->payment_method,
            'payment_status' => $this->payment_status,
            'currency' => $this->currency,
            'created_at' => $this->created_at->format('Y-m-d H:i'),
            'shipping_address' => [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'governorate' => $this->governorate ? ($this->governorate->translation->name ?? '-') : '-',
                'city' => $this->city ? ($this->city->translation->name ?? '-') : '-',
            ],
            'details' => OrderDetailResource::collection($this->whenLoaded('order_details')),
            'statuses' => $this->whenLoaded('order_statuses'),
        ];
    }
}
