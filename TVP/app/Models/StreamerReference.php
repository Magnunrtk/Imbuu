<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StreamerReference extends Model
{
    use HasFactory;

    protected $table = 'streamer_references'; 

    protected $fillable = [
        'streamer_id',  
        'status', 
        'created_at', 
        'updated_at', 
        'order_id', 
        'streamer_id'
    ];

    public $timestamps = true;
}
