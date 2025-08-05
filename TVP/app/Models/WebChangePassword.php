<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\WebChangePassword
 *
 * @property int $id
 * @property int $account_id
 * @property string $email
 * @property int $confirmation_key
 * @property mixed $created_at
 * @property Carbon $updated_at
 * @method static Builder|WebChangePassword newModelQuery()
 * @method static Builder|WebChangePassword newQuery()
 * @method static Builder|WebChangePassword query()
 * @method static Builder|WebChangePassword whereId($value)
 * @method static Builder|WebChangePassword whereAccountId($value)
 * @method static Builder|WebChangePassword whereEmail($value)
 * @method static Builder|WebChangePassword whereConfirmationKey($value)
 * @method static Builder|WebChangePassword whereCreatedAt($value)
 * @method static Builder|WebChangePassword whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class WebChangePassword extends Model
{
    /** @var string */
    protected $primaryKey = 'id';

    /** @var string[] */
    protected $fillable = [
        'id',
        'account_id',
        'email',
        'confirmation_key',
    ];

    public function account(): hasOne
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }
}
