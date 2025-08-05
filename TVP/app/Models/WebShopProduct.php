<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\WebShopProduct
 *
 * @property int $id
 * @property string $image
 * @property string $value
 * @property int $coins
 * @property string $prefix
 * @property string $suffix
 * @property int $payment_option_id
 * @property int $decimals
 * @property int $active
 * @property mixed $created_at
 * @property Carbon $updated_at
 * @property-read WebPaymentOption $payment
 * @method static Builder|WebShopProduct newModelQuery()
 * @method static Builder|WebShopProduct newQuery()
 * @method static Builder|WebShopProduct query()
 * @method static Builder|WebShopProduct whereId($value)
 * @method static Builder|WebShopProduct whereImage($value)
 * @method static Builder|WebShopProduct whereValue($value)
 * @method static Builder|WebShopProduct whereCoins($value)
 * @method static Builder|WebShopProduct wherePrefix($value)
 * @method static Builder|WebShopProduct whereSuffix($value)
 * @method static Builder|WebShopProduct wherePaymentOptionId($value)
 * @method static Builder|WebShopProduct whereDecimals($value)
 * @method static Builder|WebShopProduct whereActive($value)
 * @method static Builder|WebShopProduct whereCreatedAt($value)
 * @method static Builder|WebShopProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class WebShopProduct extends Model
{
    /** @var string[] */
    protected $fillable = [
        'id',
        'image',
        'value',
        'coins',
        'prefix',
        'suffix',
        'payment_option_id',
        'decimals',
        'active'
    ];

    /** @var string[] */
    protected $casts = [
        'active' => 'bool',
    ];

    public function payment(): hasOne
    {
        return $this->hasOne(WebPaymentOption::class, 'id', 'payment_option_id');
    }
}
