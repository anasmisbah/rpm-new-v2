<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $fillable = [
        'no_so','no_agen','name_agen','no_customer','name_customer','quantity'
    ];
}
