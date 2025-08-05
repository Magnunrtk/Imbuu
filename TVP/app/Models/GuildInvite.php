<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\GuildInvite
 *
 * @property int $player_id
 * @property int $guild_id
 * @property mixed $created_at
 * @method static Builder|GuildInvite newModelQuery()
 * @method static Builder|GuildInvite newQuery()
 * @method static Builder|GuildInvite query()
 * @method static Builder|GuildInvite wherePlayerId($value)
 * @method static Builder|GuildInvite whereGuildId($value)
 * @method static Builder|GuildInvite whereCreatedAt($value)
 * @mixin \Eloquent
 */

class GuildInvite extends Model
{
    public $timestamps = false;
    /** @var string */
    protected $primaryKey = 'player_id';
    /** @var string[] */
    protected $fillable = [
        'player_id',
        'guild_id',
        'created_at',
    ];

    public function player(): hasOne
    {
        return $this->hasOne(Player::class, 'id', 'player_id');
    }
}
