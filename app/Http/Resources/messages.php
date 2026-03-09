<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class messages extends JsonResource
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
            'contact_name' => $this->contact_name,
            'contact_email' => $this->contact_email,
            'contact_phone' => $this->contact_phone,
            'contact_subject' => $this->contact_subject,
            'contact_message' => $this->contact_message,
            'reply' => $this->reply,
            'message_type' => $this->message_type,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
        //        return parent::toArray($request);
    }
}
