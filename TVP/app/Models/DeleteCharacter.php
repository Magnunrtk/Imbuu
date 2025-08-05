<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeleteCharacter extends Model
{
    protected $table = 'players'; 

    protected $fillable = [
        'name', 'account_id',
    ];
}
