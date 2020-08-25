<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    protected $fillable = [
        'sales_order_number','agen_id'
    ];

    public function agen()
    {
        return $this->belongsTo('App\Agen');
    }

    public function delivery_orders()
    {
        return $this->hasMany('App\DeliveryOrder');
    }
}
