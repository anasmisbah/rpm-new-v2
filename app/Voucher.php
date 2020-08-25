<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'code_voucher','promo_id','customer_id'
    ];

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function promo()
    {
        return $this->belongsTo('App\Promo');
    }
}
