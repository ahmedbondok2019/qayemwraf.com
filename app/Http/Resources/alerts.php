<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class alerts extends JsonResource
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
            // 'type' => $this->type,
            // 'notifiable_type' => $this->notifiable_type,
            // 'notifiable_id' => $this->notifiable_id,
            // 'data' => [
            // 'id' => $this->data['id'],
            'title' => $this->data['title'],
            'description' => isset($this->data['description']) ? $this->data['description'] : '',
            'link' => isset($this->data['link']) ? $this->data['link'] : '',
            'image' => isset($this->data['image']) ? $this->data['image'] : '',
            // "date" => $this->data['date'],
            // "url" => $this->data['url'],
            // ],
            'read_at' => $this->read_at,
            'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ];
    }
}
