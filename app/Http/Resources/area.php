<?php

namespace App\Http\Resources;

use App\Http\Resources\city as ResourcesCity;
use App\Models\City;
use Illuminate\Http\Resources\Json\JsonResource;

class area extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = City::where('governorate_id', $this->id)->active()->get();

        return [
            'id' => $this->id,
            'area_name' => $this->name,
            'cities' => ResourcesCity::collection($data),
        ];
        //        return parent::toArray($request);
    }
}
