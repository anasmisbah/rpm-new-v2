<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    protected $fillable = [
        'title','description','image','slug','user_id','created_by','view','startdate','enddate'
    ];

    protected $dates =[
        'startdate','enddate'
    ];

    public function category()
    {
        return $this->belongsToMany('App\Category');
    }

    public function createdby()
    {
        return $this->belongsTo('App\User', 'created_by','id');
    }
}
