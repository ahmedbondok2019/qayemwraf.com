<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class offers extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->offer_translations[0]['title'],
            'slug' => $this->offer_translations[0]['slug'],
            'image' => 'offers/'.$this->offer_translations[0]['image'],
            'link' => $this->link,
        ];
        //        return parent::toArray($request);
    }
}
