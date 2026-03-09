<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Orders extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date' => date('d-M-Y', strtotime($this->created_at)),
            'status' => $this->order_status,
            'delivery_type' => $this->order_delivery_type,
        ];
        //        return parent::toArray($request);
    }
}
