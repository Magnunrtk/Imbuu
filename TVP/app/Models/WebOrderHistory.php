<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\WebOrderHistory
 *
 * @property int $id
 * @property int $account_id
 * @property string $status
 * @property float $price
 * @property int $coins
 * @property string $session_id
 * @property int $product_id
 * @property string $email
 * @property mixed $created_at
 * @property Carbon $updated_at
 * @property-read WebShopProduct $product
 * @method static Builder|WebOrderHistory newModelQuery()
 * @method static Builder|WebOrderHistory newQuery()
 * @method static Builder|WebOrderHistory query()
 * @method static Builder|WebOrderHistory whereId($value)
 * @method static Builder|WebOrderHistory whereAccountId($value)
 * @method static Builder|WebOrderHistory whereStatus($value)
 * @method static Builder|WebOrderHistory wherePrice($value)
 * @method static Builder|WebOrderHistory whereCoins($value)
 * @method static Builder|WebOrderHistory whereSessionId($value)
 * @method static Builder|WebOrderHistory whereProductId($value)
 * @method static Builder|WebOrderHistory whereEmail($value)
 * @method static Builder|WebOrderHistory whereCreatedAt($value)
 * @method static Builder|WebOrderHistory whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class WebOrderHistory extends Model
{
    /** @var string[] */
    protected $fillable = [
        'id',
        'account_id',
        'status',
        'price',
        'coins',
        'session_id',
        'product_id',
        'email',
    ];

    public function account(): hasOne
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }

    public function product(): hasOne
    {
        return $this->hasOne(WebShopProduct::class, 'id', 'product_id');
    }
}
