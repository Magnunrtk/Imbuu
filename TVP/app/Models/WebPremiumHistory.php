<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\WebPremiumHistory
 *
 * @property int $id
 * @property int $payment_id
 * @property int $account_id
 * @property string $description
 * @property int $old_premium_date
 * @property int $new_premium_date
 * @property mixed $created_at
 * @property Carbon $updated_at
 * @method static Builder|WebPremiumHistory newModelQuery()
 * @method static Builder|WebPremiumHistory newQuery()
 * @method static Builder|WebPremiumHistory query()
 * @method static Builder|WebPremiumHistory whereId($value)
 * @method static Builder|WebPremiumHistory wherePaymentId($value)
 * @method static Builder|WebPremiumHistory whereAccountId($value)
 * @method static Builder|WebPremiumHistory whereDescription($value)
 * @method static Builder|WebPremiumHistory whereOldPremiumDate($value)
 * @method static Builder|WebPremiumHistory whereNewPremiumDate($value)
 * @method static Builder|WebPremiumHistory whereCreatedAt($value)
 * @method static Builder|WebPremiumHistory whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class WebPremiumHistory extends Model
{
    protected $table = 'web_premium_histories';
    /** @var string[] */
    protected $fillable = [
        'id',
        'payment_id',
        'account_id',
        'description',
        'old_premium_date',
        'new_premium_date',
    ];

    public function account(): hasOne
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }

    public function webaccount(): hasOne
    {
        return $this->hasOne(WebAccounts::class, 'account_id', 'account_id');
    }

    public function payment(): hasOne
    {
        return $this->hasOne(WebPaymentHistory::class, 'id', 'payment_id');
    }
}
