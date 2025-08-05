<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\WebAccounts
 *
 * @property int $id
 * @property string $confirmation_key
 * @property int $account_id
 * @property string $rl_name
 * @property string $location
 * @property string $recovery_key
 * @property int $shop_coins
 * @property string $referral
 * @property int $referred_by
 * @property int $referral_bonus
 * @property int $confirmed
 * @property Carbon $next_resend
 * @property int $confirmations_count
 * @property string $creation_ip
 * @property mixed $created_at
 * @property Carbon $updated_at
 * @method static Builder|WebAccounts newModelQuery()
 * @method static Builder|WebAccounts newQuery()
 * @method static Builder|WebAccounts query()
 * @method static Builder|WebAccounts whereId($value)
 * @method static Builder|WebAccounts whereConfirmationKey($value)
 * @method static Builder|WebAccounts whereAccountId($value)
 * @method static Builder|WebAccounts whereRlName($value)
 * @method static Builder|WebAccounts whereLocation($value)
 * @method static Builder|WebAccounts whereRecoveryKey($value)
 * @method static Builder|WebAccounts whereShopCoins($value)
 * @method static Builder|WebAccounts whereReferral($value)
 * @method static Builder|WebAccounts whereReferredBy($value)
 * @method static Builder|WebAccounts whereReferralBonus($value)
 * @method static Builder|WebAccounts whereConfirmed($value)
 * @method static Builder|WebAccounts whereLastResend($value)
 * @method static Builder|WebAccounts whereConfirmationsCount($value)
 * @method static Builder|WebAccounts whereCreationIp($value)
 * @method static Builder|WebAccounts whereCreatedAt($value)
 * @method static Builder|WebAccounts whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class WebAccounts extends Model
{
    /** @var string */
    protected $primaryKey = 'account_id';

    /** @var string[] */
    protected $fillable = [
        'id',
        'confirmation_key',
        'account_id',
        'rl_name',
        'location',
        'recovery_key',
        'shop_coins',
        'referral',
        'referred_by',
        'referral_bonus',
        'confirmed',
        'next_resend',
        'confirmations_count',
        'creation_ip',
    ];

    /** @var string[] */
    protected $casts = [
        'confirmed' => 'bool',
    ];

    public function account()
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }

    public function characters()
    {
        return $this->hasMany(Player::class, 'account_id', 'account_id');
    }
}
