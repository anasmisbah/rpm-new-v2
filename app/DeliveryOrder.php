<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
    protected $fillable = [
        'delivery_order_number',
        'effective_date_start',
        'effective_date_end',
        'product',
        'quantity',
        'shipped_with',
        'shipped_via',
        'no_vehicles',
        'km_start',
        'km_end',
        'sg_meter',
        'top_seal',
        'bottom_seal',
        'temperature',
        'departure_time',
        'arrival_time',
        'unloading_start_time',
        'unloading_end_time',
        'departure_time_depot',
        'status',
        'sales_order_id',
        'driver_id',
        'bast',
        'estimate',
        'distribution',
        'admin_name',
        'knowing'

    ];

    protected $dates = [
        'departure_time',
        'arrival_time',
        'effective_date_start',
        'effective_date_end',
    ];


    public function driver()
    {
        return $this->belongsTo('App\Driver');
    }

    public function sales_order()
    {
        return $this->belongsTo('App\SalesOrder');
    }

    public function notifs()
    {
        return $this->hasMany('App\Notifdo');
    }

    public function critics()
    {
        return $this->hasOne('App\Critic');
    }
}
