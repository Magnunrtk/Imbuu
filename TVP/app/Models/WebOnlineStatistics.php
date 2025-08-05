<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\WebOnlineStatistics
 *
 * @property int $id
 * @property int $player_count
 * @property int $world_id
 * @method static Builder|WebOnlineStatistics newModelQuery()
 * @method static Builder|WebOnlineStatistics newQuery()
 * @method static Builder|WebOnlineStatistics query()
 * @method static Builder|WebOnlineStatistics whereId($value)
 * @method static Builder|WebOnlineStatistics wherePlayerCount($value)
 * @method static Builder|WebOnlineStatistics whereWorldId($value)
 * @mixin \Eloquent
 */

class WebOnlineStatistics extends Model
{
    protected $table = 'web_online_statistics';
    /** @var string[] */
    protected $fillable = [
        'id',
        'player_count',
        'world_id',
    ];
}
