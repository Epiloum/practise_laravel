<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'no';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    protected $hidden = [
        'password',
    ];

    public function products()
    {
        return $this->hasMany('App\Models\Product', 'user_register', 'no');
    }

    public function buyOrders()
    {
        return $this->hasMany('App\Models\Order', 'user_buy', 'no');
    }

    public function sellOrders()
    {
        return $this->hasManyThrough(
            'App\Models\Order',
            'App\Models\Product',
            'user_register',
            'product_no',
            'no',
            'no'
        );
    }
}
