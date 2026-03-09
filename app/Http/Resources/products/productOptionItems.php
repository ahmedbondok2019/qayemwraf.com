<?php

namespace App\Http\Resources\products;

use Illuminate\Http\Resources\Json\JsonResource;

class productOptionItems extends JsonResource
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
            'id' => intval($this->option_item_id),
            'title' => $this->option_item_title,
            'quantity' => intval($this->quantity),
            'difference_in_price' => floatval($this->difference_in_price),
            'difference_in_weight' => $this->difference_in_weight == 0 ? null : floatval($this->difference_in_weight),
            'ignore_quantity' => boolval($this->ignore_quantity),
            'isPluse' => boolval($this->isPluse),
            'isMinus' => boolval($this->isMinus),
        ];
        //        return parent::toArray($request);
    }
}
