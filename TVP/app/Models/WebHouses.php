<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\WebHouses
 *
 * @property int $id
 * @property string $name
 * @property int $house_id
 * @property int $entry_x
 * @property int $entry_y
 * @property int $entry_z
 * @property int $rent
 * @property int $town_id
 * @property int $size
 * @property mixed $created_at
 * @property Carbon $updated_at
 * @method static Builder|WebHouses newModelQuery()
 * @method static Builder|WebHouses newQuery()
 * @method static Builder|WebHouses query()
 * @method static Builder|WebHouses whereId($value)
 * @method static Builder|WebHouses whereName($value)
 * @method static Builder|WebHouses whereHouseId($value)
 * @method static Builder|WebHouses whereEntryX($value)
 * @method static Builder|WebHouses whereEntryY($value)
 * @method static Builder|WebHouses whereEntryZ($value)
 * @method static Builder|WebHouses whereRent($value)
 * @method static Builder|WebHouses whereTownId($value)
 * @method static Builder|WebHouses whereSize($value)
 * @method static Builder|WebHouses whereCreatedAt($value)
 * @method static Builder|WebHouses whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class WebHouses extends Model
{
    /** @var string */
    protected $primaryKey = 'id';

    /** @var string[] */
    protected $fillable = [
        'id',
        'name',
        'house_id',
        'entry_x',
        'entry_y',
        'entry_z',
        'rent',
        'town_id',
        'size',
    ];

}
