<?php

namespace App\Http\Resources\categories;

use Illuminate\Http\Resources\Json\JsonResource;

class categories extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (isset($this->CategoryTranslation['title'])) {
            return [
                'id' => $this->id,
                'title' => $this->CategoryTranslation['title'],
                'fixed' => $this->static == 1 ? true : false,
                'image' => 'category/'.$this->CategoryTranslation['image'],
                'sub_categories' => categories::collection($this->childs),
            ];
        }
        //        return parent::toArray($request);
    }
}
