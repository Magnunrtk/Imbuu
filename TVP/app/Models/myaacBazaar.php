<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class myaacBazaar extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $table = 'myaac_charbazaar';

    protected $fillable = [
        'hash',
        'account_old',
        'account_new',
        'player_id',
        'price',
        'date_start',
        'date_end',
        'status',
        'bid_account',
        'bid_price'
    ];
    
    public function player(): HasOne{

        return $this->hasOne(Player::class, 'id', 'player_id');
    }
    
}
