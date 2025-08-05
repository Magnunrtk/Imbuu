<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PlayerMurders extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'player_id',
        'date',
    ];

    public function player(): HasOne
    {
        return $this->hasOne(Player::class, 'id', 'player_id');
    }
}
