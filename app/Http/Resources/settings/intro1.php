<?php

namespace App\Http\Resources\settings;

use Illuminate\Http\Resources\Json\JsonResource;

class intro1 extends JsonResource
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
            'title' => (string) $this->intro_title2,
            'slug' => (string) $this->slug2,
            'image' => 'logo/'.(string) $this->image2,
        ];
        //        return parent::toArray($request);
    }
}
