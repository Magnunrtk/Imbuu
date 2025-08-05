<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryMail extends Model
{
    use HasFactory;

    protected $table = 'history_mails';

    protected $fillable = [
        'account_id',
        'date',
        'turn',
    ];

    // Desabilita timestamps
    public $timestamps = false;
}