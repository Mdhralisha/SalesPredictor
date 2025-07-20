<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class purchase_details extends Model
{
    protected $fillable = [
        'invoice_no', // Assuming an invoice ID for purchase details
        'purchase_quantity',
        'purchase_rate',
        'purchase_discount',
        'created_by',
        'vendor_id',
        'product_id',
   
    ];
    //
}
