<?php

namespace App\Http\Resources\sliders;

use App\Models\CategoryTranslation;
use Illuminate\Http\Resources\Json\JsonResource;

class sliders extends JsonResource
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
            'image' => 'sliders/'.optional($this->SliderTranslation)->image,
            'link' => $this->link,
            'category_id' => optional($this->SliderTranslation)->category,
            'category_title' => optional(CategoryTranslation::where('category_id', $this->SliderTranslation->category)->first())->title,
            'type' => 'category',
        ];
        //        return parent::toArray($request);
    }
}
