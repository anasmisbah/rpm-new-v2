<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
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
            'url'=> url('/news/read/'.$this->slug),
            'view'=>$this->view,
            'created_at'=>$this->created_at->dayName.", ".$this->created_at->day." ".$this->created_at->monthName." ".$this->created_at->year,
            'created_by'=>$this->createdby->admin->name,
            'category'=>$this->category->makeHidden(['created_at','updated_at','pivot','slug'])
        ];
    }
}
