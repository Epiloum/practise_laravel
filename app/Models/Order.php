<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'no';

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_no', 'no');
    }

    public function buyer()
    {
        return $this->belongsTo('App\Models\User', 'user_buy', 'no');
    }
    
    public function fee()
    {
        return $this->morphOne('App\Models\Fee', 'billed', 'billed_type', 'billed_no');
    }
}