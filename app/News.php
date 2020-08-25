<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = "news";

    protected $fillable = [
        'title','description','image','slug','created_by','view'
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
