<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
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
            'id'=> $this->id,
            'title'=> $this->title,
            'image'=> url('/uploads/' . $this->image),
            'url'=> $this->url,
            'created_at'=>$this->created_at->dayName.", ".$this->created_at->day." ".$this->created_at->monthName." ".$this->created_at->year,
        ];
    }
}
