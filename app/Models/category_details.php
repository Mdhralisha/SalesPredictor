<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class category_details extends Model{
    protected $fillable = [
        'created_by',
        'category_name',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }
}
