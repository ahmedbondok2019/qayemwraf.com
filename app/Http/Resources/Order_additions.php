<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Order_additions extends JsonResource
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
            'name_ar' => $this->Additions_name_ar,
            'name_en' => $this->Additions_name_en,
            'price' => $this->Additions_price,
        ];
        //        return parent::toArray($request);
    }
}
