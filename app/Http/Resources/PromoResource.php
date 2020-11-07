<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PromoResource extends JsonResource
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
            'title'=> $this->name,
            'image'=> url('/uploads/' . $this->image),
            'description'=> $this->description,
            'terms'=>$this->terms,
            'point'=>$this->point,
            'total'=>$this->total,
            'view'=>$this->view,
            'status'=>$this->status,
            'created_at'=>$this->created_at->dayName.", ".$this->created_at->day." ".$this->created_at->monthName." ".$this->created_at->year,
            'created_by'=>$this->createdby->admin->name,
        ];
    }
}
