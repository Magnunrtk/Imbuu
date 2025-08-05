<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\PlayerOnline
 *
 * @property int $id
 * @method static Builder|PlayersOnline newModelQuery()
 * @method static Builder|PlayersOnline newQuery()
 * @method static Builder|PlayersOnline query()
 * @method static Builder|PlayersOnline whereId($value)
 * @method static Builder|PlayersOnline whereWorldId($value)
 * @mixin \Eloquent
 */

class PlayersOnline extends Model
{
    public $timestamps = false;
    protected $table = 'players_online';
    /** @var string */
    protected $primaryKey = 'player_id';

    /** @var string[] */
    protected $fillable = [
        'player_id',
        'world_id',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'player_id', 'id');
    }
}
