<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'name','address','phone','avatar','user_id','route','agen_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function delivery_order()
    {
        return $this->hasMany('App\DeliveryOrder');
    }

    public function agen()
    {
        return $this->belongsTo('App\Agen');
    }
}
