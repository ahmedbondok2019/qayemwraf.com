<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class getPhoneData extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // if ($this['status'] == true){
        return [
            'id' => $this['data']['id'],
            'name' => $this['data']['name'],
            'email' => $this['data']['email'],
            'phone' => $this['data']['phone'],
            'status' => $this['data']['status'],
            'image' => $this['data']['image'],
            'hasAccount' => $this['status'] == true ? true : false,
        ];
        // }else{
        //     return [
        //         'id' => "",
        //         'name' => "",
        //         'email' => "",
        //         'phone' => $this['data'],
        //         'status' => "",
        //         'image' => "",
        //         'hasAccount' => false,
        //     ];
        // }
        //        return parent::toArray($request);
    }
}
