<?php

namespace App\Http\Resources\products;

use App\Models\Option;
use App\Models\OptionTranslation;
use Illuminate\Http\Resources\Json\JsonResource;

class productOptions extends JsonResource
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
            'id' => $this->option_id,
            'title' => optional(OptionTranslation::where('option_id', $this->option_id)->where('lang_id', app()->getLocale())->first())->title,
            'isRequired' => boolval($this->isRequired),
            'option_type' => optional(Option::find($this->option_id))->type,
            'items' => productOptionItems::collection($this->items),
        ];
        //        return parent::toArray($request);
    }
}
