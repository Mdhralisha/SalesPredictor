<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class customer_details extends Model
{
    //
       protected $fillable = [
        'customer_name',
        'customer_address',
        'customer_contactno',
    ];
}
