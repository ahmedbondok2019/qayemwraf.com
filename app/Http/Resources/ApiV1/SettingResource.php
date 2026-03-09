<?php

namespace App\Http\Resources\ApiV1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'app_name' => $this->translate('app_name'),
            'app_meta_title' => $this->translate('app_meta_title'),
            'app_meta_desc' => $this->translate('app_meta_desc'),
            'logo' => $this->logo ? asset($this->logo) : null,
            'logo_dark' => $this->logo_dark ? asset($this->logo_dark) : null,
            'fav_icon' => $this->fav_icon ? asset($this->fav_icon) : null,
            'address' => $this->translate('address'),
            'phone' => $this->phone,
            'contact_email' => $this->contact_email,
            'social_links' => [
                'facebook' => $this->facebook,
                'instagram' => $this->instagram,
                'twitter' => $this->twitter,
                'youtube' => $this->youtube,
                'whatsapp' => $this->whatsapp,
                'linkedin' => $this->linkedin,
            ],
            'messages' => [
                'processing' => $this->translate('msg_processing'),
                'shipped' => $this->translate('msg_shipped'),
                'completed' => $this->translate('msg_completed'),
                'cancelled' => $this->translate('msg_cancelled'),
                'delivered' => $this->translate('msg_delivered'),
            ],
            'gift_settings' => [
                'max_gift_items' => (int)($this->max_gift_items ?? 1),
                'min_order_for_gift' => (float)($this->min_order_for_gift ?? 0),
            ],
        ];
    }
}
