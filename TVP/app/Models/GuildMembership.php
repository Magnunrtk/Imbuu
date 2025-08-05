<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\GuildMembership
 *
 * @property int $player_id
 * @property int $guild_id
 * @property int $rank_id
 * @property string $nick
 * @method static Builder|GuildMembership newModelQuery()
 * @method static Builder|GuildMembership newQuery()
 * @method static Builder|GuildMembership query()
 * @method static Builder|GuildMembership wherePlayerId($value)
 * @method static Builder|GuildMembership whereGuildId($value)
 * @method static Builder|GuildMembership whereRankId($value)
 * @method static Builder|GuildMembership whereNick($value)
 * @mixin \Eloquent
 */

class GuildMembership extends Model
{
    public $timestamps = false;
    protected $table = 'guild_membership';
    /** @var string */
    protected $primaryKey = 'player_id';
    /** @var string[] */
    protected $fillable = [
        'player_id',
        'guild_id',
        'rank_id',
        'nick',
        'created_at',
    ];

    public function ranks(): hasOne
    {
        return $this->hasOne(GuildRank::class, 'id', 'rank_id');
    }

    public function player(): hasOne
    {
        return $this->hasOne(Player::class, 'id', 'player_id');
    }

    public function guild(): hasOne
    {
        return $this->hasOne(Guild::class, 'id', 'guild_id');
    }
}
