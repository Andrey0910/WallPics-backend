<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SetPhotosResource extends JsonResource
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
            'file_origin' => $this->file_origin,
            'file_medium' => $this->file_medium,
            'file_little' => $this->file_little,
            'like' => $this->like,
            'photos_id' => $this->photos_id,
            'clients_id' => $this->clients_idd,
            'created_at' => $this->created_at,
//            'photos' => $this->photos
        ];
    }
}
