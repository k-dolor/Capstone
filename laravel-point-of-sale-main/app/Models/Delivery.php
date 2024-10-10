<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{  
    use HasFactory;

    protected $fillable = [
        'order_id', 'customer_name', 'delivery_address', 'delivery_date', 'status', 'driver_name'
    ];
    
}
