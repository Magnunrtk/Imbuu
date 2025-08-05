<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\WebGuildApplication
 *
 * @property int $id
 * @property int $player_id
 * @property int $guild_id
 * @property string $text
 * @property int $status
 * @property mixed $created_at
 * @property Carbon $updated_at
 * @method static Builder|WebGuildApplication newModelQuery()
 * @method static Builder|WebGuildApplication newQuery()
 * @method static Builder|WebGuildApplication query()
 * @method static Builder|WebGuildApplication whereId($value)
 * @method static Builder|WebGuildApplication wherePlayerId($value)
 * @method static Builder|WebGuildApplication whereGuildId($value)
 * @method static Builder|WebGuildApplication whereText($value)
 * @method static Builder|WebGuildApplication whereStatus($value)
 * @method static Builder|WebGuildApplication whereCreatedAt($value)
 * @method static Builder|WebGuildApplication whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class WebGuildApplication extends Model
{
    /** @var string */
    protected $primaryKey = 'id';

    /** @var string[] */
    protected $fillable = [
        'id',
        'player_id',
        'guild_id',
        'text',
        'status',
    ];

    public function player(): hasOne
    {
        return $this->hasOne(Player::class, 'id', 'player_id');
    }

    public function guild(): hasOne
    {
        return $this->hasOne(Guild::class, 'id', 'guild_id');
    }
}
