<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\WebHouseMoveOut
 *
 * @property int $id
 * @property int $house_id
 * @property Carbon $date
 * @property int $time
 * @property mixed $created_at
 * @property Carbon $updated_at
 * @method static Builder|WebHouseMoveOut newModelQuery()
 * @method static Builder|WebHouseMoveOut newQuery()
 * @method static Builder|WebHouseMoveOut query()
 * @method static Builder|WebHouseMoveOut whereId($value)
 * @method static Builder|WebHouseMoveOut whereHouseId($value)
 * @method static Builder|WebHouseMoveOut whereDate($value)
 * @method static Builder|WebHouseMoveOut whereTime($value)
 * @method static Builder|WebHouseMoveOut whereCreatedAt($value)
 * @method static Builder|WebHouseMoveOut whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class WebHouseMoveOut extends Model
{
    /** @var string[] */
    protected $fillable = [
        'id',
        'house_id',
        'date',
        'time',
    ];

    public function transfer(): hasOne
    {
        return $this->hasOne(WebHouseTransfer::class, 'move_out_id', 'id');
    }
}
