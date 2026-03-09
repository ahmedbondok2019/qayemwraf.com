<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class notification extends JsonResource
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
            'receive_no_qualification' => $this->receive_no_qualification == 0 ? false : true,
            'explanation_receive_no_qualification' => $this->explanation_receive_no_qualification,
            'receive_outside_scope' => $this->receive_outside_scope == 0 ? false : true,
            'explanation_receive_outside_scope' => $this->explanation_receive_outside_scope,
            'alert_tone' => $this->alert_tone == 0 ? false : true,
            'alert_status' => $this->alert_status == 0 ? false : true,
        ];
        //        return parent::toArray($request);
    }
}
