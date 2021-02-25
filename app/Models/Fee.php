<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;
    
    public function billed()
    {
        return $this->morphTo(__FUNCTION__, 'billed_type', 'billed_no');
    }
}
