<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code_coupon','customer_id'
    ];

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
