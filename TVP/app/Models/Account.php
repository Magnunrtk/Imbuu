<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use jeremykenedy\LaravelRoles\Models\Permission;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;

/**
 * App\Models\Account
 *
 * @property int $id
 * @property string $name
 * @property string $password
 * @property string $secret
 * @property int $type
 * @property int $premium_ends_at
 * @property string $email
 * @property int $creation
 * @property-read Collection|Role[] $roles
 * @property-read int|null $roles_count
 * @property-read Collection|Permission[] $userPermissions
 * @property-read int|null $user_permissions_count
 * @method static Builder|Account newModelQuery()
 * @method static Builder|Account newQuery()
 * @method static Builder|Account query()
 * @method static Builder|Account whereId($value)
 * @method static Builder|Account whereName($value)
 * @method static Builder|Account wherePassword($value)
 * @method static Builder|Account whereSecret($value)
 * @method static Builder|Account whereType($value)
 * @method static Builder|Account wherePremiumEndsAt($value)
 * @method static Builder|Account whereEmail($value)
 * @method static Builder|Account whereCreation($value)
 * @mixin \Eloquent
 */

class Account extends Authenticatable
{
    public $timestamps = false;
    use HasFactory, Notifiable, HasRoleAndPermission;

    /** @var string */
    protected $primaryKey = 'id';

    /** @var string[] */
    protected $fillable = [
        'id',
        'name',
        'password',
        'secret',
        'type',
        'premium_ends_at',
        'email',
        'creation',
        'confirmed',
    ];

    /** @var string[] */
    protected $hidden = [
        'password',
        'secret',
    ];

    /** @var string[] */
    protected $casts = [
        'confirmed' => 'bool',
    ];


    public function characters(): hasMany
    {
        return $this->hasMany(Player::class, 'account_id', 'id');
    }

    public function webaccount(): hasOne
    {
        return $this->hasOne(WebAccounts::class, 'account_id', 'id');
    }

    public function banned(): hasOne
    {
        return $this->hasOne(AccountBan::class, 'account_id', 'id');
    }

    public function webemail(): hasMany
    {
        return $this->hasMany(WebChangeEmail::class, 'account_id', 'id');
    }

    public function payment_history(): hasMany
    {
        return $this->hasMany(WebPaymentHistory::class, 'account_id', 'id');
    }

    public function premium_history(): hasMany
    {
        return $this->hasMany(WebPremiumHistory::class, 'account_id', 'id');
    }

    public function awaitingEmailChange(): bool
    {
        foreach ($this->webemail as $user) {
            if(!$user->confirmed) {
                return true;
            }
        }
        return false;
    }

    public function onGoingEmailChange(): WebChangeEmail|null
    {
        foreach ($this->webemail as $user) {
            if(!$user->confirmed) {
                return $user;
            }
        }
        return null;
    }

    public function isPremium(): bool
    {
        if(Carbon::createFromTimestamp($this->premium_ends_at)->toDateTimeString() >= Carbon::now()) {
            return true;
        }
        return false;
    }

    public function hasClaimablePremium(): bool
    {
        foreach ($this->payment_history as $payment) {
            if(!$payment->claimed) {
                return true;
            }
        }
        return false;
    }
}
