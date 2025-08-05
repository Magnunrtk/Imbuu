<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\WebManualTransaction
 *
 * @property int $id
 * @property int $account_id
 * @property string $external_name
 * @property string $receiver_name
 * @property string $server_name
 * @property int $price
 * @property int $coins
 * @property int $payment_option_id
 * @property int $product_id
 * @property int $status
 * @property mixed $created_at
 * @property Carbon $updated_at
 * @property-read WebAccounts $webAccount
 * @property-read WebPaymentOption $payment
 * @property-read WebShopProduct $product
 * @method static Builder|WebManualTransaction newModelQuery()
 * @method static Builder|WebManualTransaction newQuery()
 * @method static Builder|WebManualTransaction query()
 * @method static Builder|WebManualTransaction whereId($value)
 * @method static Builder|WebManualTransaction whereAccountId($value)
 * @method static Builder|WebManualTransaction whereExternalName($value)
 * @method static Builder|WebManualTransaction whereReceiverName($value)
 * @method static Builder|WebManualTransaction serverServerName($value)
 * @method static Builder|WebManualTransaction wherePrice($value)
 * @method static Builder|WebManualTransaction whereCoins($value)
 * @method static Builder|WebManualTransaction wherePaymentOptionId($value)
 * @method static Builder|WebManualTransaction whereProductId($value)
 * @method static Builder|WebManualTransaction whereStatus($value)
 * @method static Builder|WebManualTransaction whereCreatedAt($value)
 * @method static Builder|WebManualTransaction whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class WebManualTransaction extends Model
{
    /** @var string[] */
    protected $fillable = [
        'id',
        'account_id',
        'external_name',
        'receiver_name',
        'server_name',
        'price',
        'coins',
        'payment_option_id',
        'product_id',
        'status',
    ];

    public function webaccount(): hasOne
    {
        return $this->hasOne(WebAccounts::class, 'account_id', 'account_id');
    }

    public function payment(): hasOne
    {
        return $this->hasOne(WebPaymentOption::class, 'id', 'payment_option_id');
    }

    public function product(): hasOne
    {
        return $this->hasOne(WebShopProduct::class, 'id', 'product_id');
    }
}
