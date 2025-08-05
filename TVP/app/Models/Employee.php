<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['employee_name', 'pix_key', 'position'];

    protected $table = 'employees';
    public $timestamps = true;
}
