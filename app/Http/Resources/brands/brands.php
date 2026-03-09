<?php

namespace App\Http\Resources\brands;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class brands extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        App::setLocale($request->header('lang'));
        if ($this->BrandTranslations != null) {
            return [
                'id' => $this->id,
                'title' => $this->BrandTranslations['title'] ?? '',
                'image' => 'brands/'.$this->BrandTranslations['image'] ?? '',
            ];
        } else {
            return [
                'id' => $this->id,
                'title' => '',
                'image' => '',
            ];
        }

        //        return parent::toArray($request);
    }
}
