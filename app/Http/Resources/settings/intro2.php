<?php

namespace App\Http\Resources\settings;

use Illuminate\Http\Resources\Json\JsonResource;

class intro2 extends JsonResource
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
            'title' => (string) $this->intro_title3,
            'slug' => (string) $this->slug3,
            'image' => 'logo/'.(string) $this->image3,
        ];
        //        return parent::toArray($request);
    }
}
