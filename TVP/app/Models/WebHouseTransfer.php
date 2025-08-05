<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\WebHouseTransfer
 *
 * @property int $id
 * @property int $move_out_id
 * @property int $new_owner
 * @property int $price
 * @property int $accepted
 * @property mixed $created_at
 * @property Carbon $updated_at
 * @method static Builder|WebHouseTransfer newModelQuery()
 * @method static Builder|WebHouseTransfer newQuery()
 * @method static Builder|WebHouseTransfer query()
 * @method static Builder|WebHouseTransfer whereId($value)
 * @method static Builder|WebHouseTransfer whereMoveOutId($value)
 * @method static Builder|WebHouseTransfer whereNewOwner($value)
 * @method static Builder|WebHouseTransfer wherePrice($value)
 * @method static Builder|WebHouseTransfer whereAccepted($value)
 * @method static Builder|WebHouseTransfer whereCreatedAt($value)
 * @method static Builder|WebHouseTransfer whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class WebHouseTransfer extends Model
{
    /** @var string[] */
    protected $fillable = [
        'id',
        'move_out_id',
        'new_owner',
        'accepted',
        'price',
    ];

    /** @var string[] */
    protected $casts = [
        'accepted' => 'bool',
    ];

    public function player(): hasOne
    {
        return $this->hasOne(Player::class, 'id', 'new_owner');
    }
}
