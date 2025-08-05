<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopHist extends Model
{
    use HasFactory;

    protected $table = 'store_history';
    protected $fillable = ['description', 'coin_amount', 'time'];
}
