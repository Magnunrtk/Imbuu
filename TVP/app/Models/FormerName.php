<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormerName extends Model
{
    protected $table = 'former_name';

    protected $fillable = ['name', 'player_id', 'time', 'create_at'];
    public $timestamps = false; 
}
