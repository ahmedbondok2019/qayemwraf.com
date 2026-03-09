<?php

namespace App\Http\Resources\products;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class productRates extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = User::find($this->user_id);

        return [
            'id' => $this->id,
            'rate' => $this->rating,
            'notes' => $this->notes,
            'image' => isset($user) ? 'users/'.$user->image : '',
            'name' => isset($user) ? $user->name : '',
            'date' => $this->created_at,
        ];
        //        return parent::toArray($request);
    }
}
