<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agen extends Model
{
    protected $fillable = [
        'name','address','phone','website','logo','npwp','user_id'
    ];

    public function customers()
    {
        return $this->hasMany('App\Customer');
    }

    public function sales_orders()
    {
        return $this->hasMany('App\SalesOrder');
    }

    public function drivers()
    {
        return $this->hasMany('App\Driver');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
