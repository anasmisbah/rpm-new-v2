<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    protected $fillable = [
        'sales_order_number','agen_id','customer_id'
    ];

    public function agen()
    {
        return $this->belongsTo('App\Agen');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function delivery_orders()
    {
        return $this->hasMany('App\DeliveryOrder');
    }
}
