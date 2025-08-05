<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BazaarHist extends Model
{
    use HasFactory;

    protected $table = 'bazaar_hist';

    public $timestamps = false;
    
    protected $fillable = [
        'coins',
        'date',
    ];
}
