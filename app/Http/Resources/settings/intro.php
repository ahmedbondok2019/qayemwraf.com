<?php

namespace App\Http\Resources\settings;

use Illuminate\Http\Resources\Json\JsonResource;

class intro extends JsonResource
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
            'title' => (string) $this->intro_title1,
            'slug' => (string) $this->slug1,
            'image' => 'logo/'.(string) $this->image1,
        ];
        //        return parent::toArray($request);
    }
}
