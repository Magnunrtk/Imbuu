<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTimeClock extends Model
{
    use HasFactory;

    protected $table = 'employee_time_clock';

    protected $fillable = [
        'employee_name',
        'task',
        'elapsed_time',
        'status',
        'task_day',
        'date_only',
    ];

    public $timestamps = false;
}
