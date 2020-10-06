<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'url'=> url('/event/read/'.$this->slug),
            'view'=>$this->view,
            'start'=>$this->startdate->format('l, d F Y'),
            'end'=>$this->enddate->format('l, d F Y'),
            'created_at'=>$this->created_at->format('d F Y'),
            'created_by'=>$this->createdby->admin->name,
            'category'=>$this->category->makeHidden(['created_at','updated_at','pivot','slug'])
        ];
    }
}
