<?php

namespace App\Http\Resources\products;

use Illuminate\Http\Resources\Json\JsonResource;

class images extends JsonResource
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
            'image' => 'products/'.$this->image,
        ];
        //        return parent::toArray($request);
    }
}
