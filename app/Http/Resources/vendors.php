<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class vendors extends JsonResource
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
            'status' => $this->status,
            'image' => $this->image,
            'type' => 'vendor',
            'token' => $token,
        ];
        //        return parent::toArray($request);
    }
}
