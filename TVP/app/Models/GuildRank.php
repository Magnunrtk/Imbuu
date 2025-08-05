<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GuildRank
 *
 * @property int $id
 * @property int $guild_id
 * @property string $name
 * @property int $level
 * @property int $order_id
 * @method static Builder|GuildRank newModelQuery()
 * @method static Builder|GuildRank newQuery()
 * @method static Builder|GuildRank query()
 * @method static Builder|GuildRank whereId($value)
 * @method static Builder|GuildRank whereGuildId($value)
 * @method static Builder|GuildRank whereName($value)
 * @method static Builder|GuildRank whereLevel($value)
 * @method static Builder|GuildRank whereOrderId($value)
 * @mixin \Eloquent
 */

class GuildRank extends Model
{
    public $timestamps = false;

    /** @var string[] */
    protected $fillable = [
        'id',
        'guild_id',
        'name',
        'level',
        'order_id',
    ];
}
