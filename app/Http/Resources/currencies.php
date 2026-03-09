<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class currencies extends JsonResource
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
            'slug' => $this->translations[0]['slug'],
            'name' => $this->translations[0]['name'],
            'sign' => $this->translations[0]['currency_sign'],
        ];
        //        return parent::toArray($request);
    }
}
