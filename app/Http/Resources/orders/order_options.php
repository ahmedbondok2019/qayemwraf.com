<?php

namespace App\Http\Resources\orders;

use App\Models\OptionItemTranslation;
use App\Models\OptionTranslation;
use Illuminate\Http\Resources\Json\JsonResource;

class order_options extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->order_details_id) {
            return [
                'id' => intval($this->id),
                'product_id' => $this->product_id,
                'option_id' => $this->option_id,
                'option' => optional(OptionTranslation::where('option_id', $this->option_id)->where('lang_id', app()->getLocale())->first())->title,
                'option_item_id' => $this->option_item_id,
                'option_item' => optional(OptionItemTranslation::where('option_item_id', $this->option_item_id)->where('lang_id', app()->getLocale())->first())->title,
                'difference_in_price' => $this->difference_in_price,
                'isPluse' => $this->isPluse,
                'isMinus' => $this->isMinus,
            ];
        }

        //        return parent::toArray($request);
    }
}
