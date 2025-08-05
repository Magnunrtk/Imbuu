<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\WebGuildResignLeadership
 *
 * @property int $id
 * @property int $player_id
 * @property int $guild_id
 * @property int $new_player_id
 * @property mixed $created_at
 * @property Carbon $updated_at
 * @method static Builder|WebGuildResignLeadership newModelQuery()
 * @method static Builder|WebGuildResignLeadership newQuery()
 * @method static Builder|WebGuildResignLeadership query()
 * @method static Builder|WebGuildResignLeadership whereId($value)
 * @method static Builder|WebGuildResignLeadership wherePlayerId($value)
 * @method static Builder|WebGuildResignLeadership whereGuildId($value)
 * @method static Builder|WebGuildResignLeadership whereNewPlayerId($value)
 * @method static Builder|WebGuildResignLeadership whereCreatedAt($value)
 * @method static Builder|WebGuildResignLeadership whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class WebGuildResignLeadership extends Model
{
    /** @var string */
    protected $primaryKey = 'id';

    /** @var string[] */
    protected $fillable = [
        'id',
        'player_id',
        'guild_id',
        'new_player_id',
    ];
}
