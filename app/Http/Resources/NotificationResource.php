<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            "id"              => $this->id,
            "read_at"         => $this->read_at,
            "type"            => $this->type,
            "notifiable_type" => $this->notifiable_type,
            "notifiable_id"   => $this->notifiable_id,
            "title"           => $this->data['title'],
            "body"            => $this->data['body'],
            "image"           => $this->data['image'],
            "icon"            => $this->data['icon'],
            "data"            => $this->data['data'],
        ];
    }
}
