<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\WebCreature
 *
 * @property int $id
 * @property string $name
 * @property mixed $created_at
 * @property Carbon $updated_at
 * @method static Builder|WebCreature newModelQuery()
 * @method static Builder|WebCreature newQuery()
 * @method static Builder|WebCreature query()
 * @method static Builder|WebCreature whereId($value)
 * @method static Builder|WebCreature whereName($value)
 * @method static Builder|WebCreature whereCreatedAt($value)
 * @method static Builder|WebCreature whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class WebCreature extends Model
{
    /** @var string[] */
    protected $fillable = [
        'id',
        'name',
    ];

    public function killStatistics(): HasMany
    {
        return $this->hasMany(KillStatistic::class, 'name', 'name');
    }
}
