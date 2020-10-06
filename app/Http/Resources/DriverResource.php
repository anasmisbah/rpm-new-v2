<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
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
            "id"=> $this->id ,
            "name"=> $this->name,
            "address"=> $this->address ,
            "phone"=> $this->phone ,
            "avatar"=> url('/uploads/' . $this->avatar) ,
            "route"=> $this->route ,
            "user_id"=> $this->user_id ,
            "agen_id"=> $this->agen_id ,
            "created_at"=> $this->created_at->format('d F Y'),
            "updated_at"=> $this->updated_at->format('d F Y') ,
        ];
    }
}
