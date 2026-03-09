<?php

namespace App\Http\Resources\transfers;

use App\Models\ProductTranslation;
use Illuminate\Http\Resources\Json\JsonResource;

class purchase extends JsonResource
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
            'text_to_show' => __('dashboard.amount').$this->total
        .__('dashboard.purchase :').optional(ProductTranslation::find($this->product_id))->product_name,
        ];
        //        return parent::toArray($request);
    }
}
