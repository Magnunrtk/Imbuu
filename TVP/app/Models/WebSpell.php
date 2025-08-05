<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\WebSpell
 *
 * @property int $id
 * @property string $method
 * @property int $price
 * @property int $coins
 * @property string $external_id
 * @property mixed $created_at
 * @property Carbon $updated_at
 * @method static Builder|WebSpell newModelQuery()
 * @method static Builder|WebSpell newQuery()
 * @method static Builder|WebSpell query()
 * @method static Builder|WebSpell whereId($value)
 * @method static Builder|WebSpell whereMethod($value)
 * @method static Builder|WebSpell wherePrice($value)
 * @method static Builder|WebSpell whereCoins($value)
 * @method static Builder|WebSpell whereExternalId($value)
 * @method static Builder|WebSpell whereCreatedAt($value)
 * @method static Builder|WebSpell whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class WebSpell extends Model
{
    /** @var string[] */
    protected $fillable = [
        'id',
        'name',
        'words',
        'category',
        'mana',
        'mlvl',
        'premium',
        'vocations',
        'param',
        'learn',
    ];
}
