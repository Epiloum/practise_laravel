<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'no';

    public function order()
    {
        return $this->hasMany('App\Models\Order', 'product_no', 'no');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_register', 'no');
    }
}
