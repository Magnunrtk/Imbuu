<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSystem extends Model
{
    protected $table = 'email_system';

    protected $fillable = ['quantity', 'domain', 'date'];

    public $timestamps = false;

    protected $primaryKey = 'id';
}
