<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class contact_details extends JsonResource
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
            'phone' => $this->phone,
            'contact_email' => $this->contact_email,
            'facebook' => $this->facebook,
            'youtube' => $this->youtube,
            'whatsapp' => $this->whatsapp,
            'twitter' => $this->twitter,
            'instagram' => $this->instagram,
            'support_email' => $this->support_email,
        ];
        //        return parent::toArray($request);
    }
}
