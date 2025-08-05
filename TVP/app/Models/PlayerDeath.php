<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\PlayerDeath
 *
 * @property int $player_id
 * @property int $time
 * @property int $level
 * @property string $killed_by
 * @property int $is_player
 * @property string $mostdamage_by
 * @property int $mostdamage_is_player
 * @property int $unjustified
 * @property int $mostdamage_unjustified
 * @method static Builder|PlayerDeath newModelQuery()
 * @method static Builder|PlayerDeath newQuery()
 * @method static Builder|PlayerDeath query()
 * @method static Builder|PlayerDeath wherePlayerId($value)
 * @method static Builder|PlayerDeath whereTime($value)
 * @method static Builder|PlayerDeath whereLevel($value)
 * @method static Builder|PlayerDeath whereKilledBy($value)
 * @method static Builder|PlayerDeath whereIsPlayer($value)
 * @method static Builder|PlayerDeath whereMostdamageBy($value)
 * @method static Builder|PlayerDeath whereMostdamageIsPlayer($value)
 * @method static Builder|PlayerDeath whereUnjustified($value)
 * @method static Builder|PlayerDeath whereMostdamageUnjustified($value)
 * @mixin \Eloquent
 */

class PlayerDeath extends Model
{
    public $timestamps = false;
    /** @var string */
    protected $primaryKey = 'player_id';

    /** @var string[] */
    protected $fillable = [
        'player_id',
        'time',
        'level',
        'killed_by',
        'is_played',
        'mostdamage_by',
        'mostdamage_is_player',
        'unjustified',
        'mostdamage_unjustified',
    ];

    /** @var string[] */
    protected $casts = [
        'is_played' => 'bool',
        'mostdamage_is_player' => 'bool',
        'unjustified' => 'bool',
        'mostdamage_unjustified' => 'bool',
    ];

    public function player(): hasOne
    {
        return $this->hasOne(Player::class, 'id', 'player_id');
    }
}
