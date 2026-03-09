<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class users extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'country_id' => $this->country_id,
            'country_code' => $this->country_code,
            'facebook_id' => $this->facebook_id,
            'status' => $this->status,
            'customer_group' => $this->customer_group,
            'permission_sms' => (bool) $this->permission_sms,
            'permission_email' => (bool) $this->permission_email,
            'permission_phone_call' => (bool) $this->permission_phone_call,
            'accept' => (bool) $this->accept,
            'gift_page_enabled' => (bool) $this->gift_page_enabled,
            'image' => $this->image ? 'users/' . $this->image : '',
            'type' => 'user',
            'token' => $token,
        ];
        //        return parent::toArray($request);
    }
}
