<?php

namespace App\Http\Resources;

use App\Models\Option;
use App\Models\OptionItem;
use Illuminate\Http\Resources\Json\JsonResource;

class cart_options extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $option = Option::where('id', $this->option_id)->whereHas('translations')->first();
        $optionItem = OptionItem::where('id', $this->option_item_id)->whereHas('translations')->first();

        return [
            'id' => $this->id,
            'option_title' => $option ? $option->translations[0]['title'] : '',
            'option_item_title' => $optionItem ? $optionItem->translations[0]['title'] : '',
        ];

        //        return parent::toArray($request);
    }
}
