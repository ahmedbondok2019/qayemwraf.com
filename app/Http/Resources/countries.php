<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class countries extends JsonResource
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
            'name' => $this->name,
            'code' => $this->code,
            'phone_code' => $this->phone_code,
            'image' => $this->image ? 'countries/' . $this->image : '',
        ];
    }
}
