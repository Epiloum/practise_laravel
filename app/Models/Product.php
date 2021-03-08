<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function order()
    {
        return $this->hasMany('App\Models\Order', 'product_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_register', 'id');
    }

    public function fee()
    {
        return $this->morphOne('App\Models\Fee', 'billed');
    }
}
