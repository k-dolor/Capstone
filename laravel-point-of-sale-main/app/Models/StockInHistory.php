<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockInHistory extends Model
{
    protected $fillable = ['product_id', 'quantity_added', 'date_added'];
}
