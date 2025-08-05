<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EmployeePayment extends Model
{
    protected $table = 'employee_payments';
    
    protected $fillable = [
        'employee_name',
        'pay_due',
        'payment_date',
        'proof'
    ];

    public $timestamps = false; 
}
