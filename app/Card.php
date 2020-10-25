<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'name','image'
    ];

    public function customers()
    {
        return $this->hasMany('App\Customer');
    }
}
