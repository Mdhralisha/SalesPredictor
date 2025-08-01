<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product_details extends Model
{
    protected $fillable = [
        'product_name',
        'product_quantity',
        'product_rate',
        'sales_rate',
        'category_id',
        'created_by',
        'product_unit',
        'vendor_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }
    public function category()
{
    return $this->belongsTo(category_details::class, 'category_id');
}
    public function vendor()
    {
        return $this->belongsTo('App\Models\vendor_details', 'vendor_id');
    }
    
   
}
