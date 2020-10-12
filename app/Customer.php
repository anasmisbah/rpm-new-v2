<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name','address','member','phone','website','logo','npwp','agen_id','reward','user_id','no_customer','coupon'
    ];

    public function delivery_order()
    {
        return $this->hasMany('App\DeliveryOrder');
    }

    public function coupons()
    {
        return $this->hasMany('App\Coupon');
    }

    public function vouchers()
    {
        return $this->hasMany('App\Voucher');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function agen()
    {
        return $this->belongsTo('App\Agen');
    }
}
