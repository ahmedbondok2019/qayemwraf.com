<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class code extends JsonResource
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
            'value' => $this->promoValue,
            'type' => $this->promoType == 1 ? 'percentage' : 'fixed',
            'one_use' => $this->promoType == 1 ? true : false,
            'max_value' => $this->promoMaxAmount,
        ];
        //        return parent::toArray($request);
    }
}
