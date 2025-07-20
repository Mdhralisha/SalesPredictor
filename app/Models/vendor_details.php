<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vendor_details extends Model
{
    protected $fillable = [
        'vendor_name',
        'vendor_address',
        'vendor_email',
        'vendor_contactno',
    ];

}
