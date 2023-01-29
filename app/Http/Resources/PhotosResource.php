<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PhotosResource extends JsonResource
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
            'id' => $this->id,
            'origin_name_photo' => $this->origin_name_photo,
            'file_origin' => $this->file_origin,
            'like' => $this->like,
            'isActive' => $this->isActive,
            'isDelete' => $this->isDelete,
            'clients_id' => $this->clients_id,
            'categories_id' => $this->categories_id,
            'created_at' => $this->created_at,
        ];
    }
}
