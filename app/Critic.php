<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Critic extends Model
{
    protected $table ='critics';
    protected $fillable = [
        'critics_suggestion','service','rating','delivery_order_id'
    ];

    public function delivery_order()
    {
        return $this->belongsTo('App\DeliveryOrder');
    }
}
