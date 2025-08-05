<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VipAccumulated extends Model
{
    use HasFactory;

    protected $table = 'vip_accumulated';

    protected $fillable = [
        'account_id',
        'days',
        'date',
    ];

    public $timestamps = false;
}
