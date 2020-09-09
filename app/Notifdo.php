<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notifdo extends Model
{
    protected $table = "notif_do";

    protected $fillable = [
        'description','driver','date','delivery_order_id'
    ];

    protected $dates =[
        'date'
    ];

    public function delivery_order()
    {
        return $this->belongsTo('App\DeliveryOrder');
    }
}
