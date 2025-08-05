<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\KillStatistic
 *
 * @property int $id
 * @property string $name
 * @property int $killed_by
 * @property int $killed
 * @property int $time
 * @property mixed $created_at
 * @property Carbon $updated_at
 * @method static Builder|KillStatistic newModelQuery()
 * @method static Builder|KillStatistic newQuery()
 * @method static Builder|KillStatistic query()
 * @method static Builder|KillStatistic whereId($value)
 * @method static Builder|KillStatistic whereName($value)
 * @method static Builder|KillStatistic whereKilledBy($value)
 * @method static Builder|KillStatistic whereKilled($value)
 * @method static Builder|KillStatistic whereTime($value)
 * @method static Builder|KillStatistic whereCreatedAt($value)
 * @method static Builder|KillStatistic whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class KillStatistic extends Model
{
    /** @var string[] */
    protected $fillable = [
        'id',
        'name',
        'killed_by',
        'killed',
        'time',
    ];
}
