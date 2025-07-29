<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\CodeCoverage\Report\Html\CustomCssFile;

class sales_details extends Model
{
    //
    
    protected $fillable = [
  
        'invoice_no', // Assuming an invoice ID for sales details
        'sales_rate', // Assuming a precision of 8 and scale of 2 for the sales rate 
        'sales_quantity', // Assuming a precision for sales quantity
        'sales_discount', // Optional
        'customer_id', // Assuming a customer ID for sales details
        'product_id', // Assuming a product ID for sales details
        'user_id', // Assuming this is the user who created the sales record
    ];


    public function product()    {
        return $this->belongsTo(product_details::class, 'product_id');
    }
        public function customer()    {
        return $this->belongsTo(Customer_details::class, 'customer_id');
    }

}
