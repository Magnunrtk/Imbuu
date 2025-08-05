<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\WebAccountRecovery
 *
 * @property int $id
 * @property int $account_id
 * @property string $email
 * @property string $old_email
 * @property string $confirmation_key
 * @property int $confirmed
 * @property mixed $created_at
 * @property Carbon $updated_at
 * @method static Builder|WebAccountRecovery newModelQuery()
 * @method static Builder|WebAccountRecovery newQuery()
 * @method static Builder|WebAccountRecovery query()
 * @method static Builder|WebAccountRecovery whereId($value)
 * @method static Builder|WebAccountRecovery whereAccountId($value)
 * @method static Builder|WebAccountRecovery whereEmail($value)
 * @method static Builder|WebAccountRecovery whereOldEmail($value)
 * @method static Builder|WebAccountRecovery whereConfirmationKey($value)
 * @method static Builder|WebAccountRecovery whereConfirmed($value)
 * @method static Builder|WebAccountRecovery whereCreatedAt($value)
 * @method static Builder|WebAccountRecovery whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class WebAccountRecovery extends Model
{
    protected $table = 'web_account_recoveries';

    /** @var string */
    protected $primaryKey = 'id';

    /** @var string[] */
    protected $fillable = [
        'id',
        'account_id',
        'email',
        'old_email',
        'confirmation_key',
        'confirmed',
    ];

    /** @var string[] */
    protected $casts = [
        'confirmed' => 'bool',
    ];

    public function account(): hasOne
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }
}
