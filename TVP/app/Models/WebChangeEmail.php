<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\WebChangeEmail
 *
 * @property int $id
 * @property int $account_id
 * @property string $email
 * @property string $old_email
 * @property Carbon $change_date
 * @property int $confirmed
 * @property int $confirmation_key
 * @property mixed $created_at
 * @property Carbon $updated_at
 * @method static Builder|WebChangeEmail newModelQuery()
 * @method static Builder|WebChangeEmail newQuery()
 * @method static Builder|WebChangeEmail query()
 * @method static Builder|WebChangeEmail whereId($value)
 * @method static Builder|WebChangeEmail whereAccountId($value)
 * @method static Builder|WebChangeEmail whereEmail($value)
 * @method static Builder|WebChangeEmail whereOldEmail($value)
 * @method static Builder|WebChangeEmail whereToken($value)
 * @method static Builder|WebChangeEmail whereChangeDate($value)
 * @method static Builder|WebChangeEmail whereConfirmed($value)
 * @method static Builder|WebChangeEmail whereConfirmationKey($value)
 * @method static Builder|WebChangeEmail whereCreatedAt($value)
 * @method static Builder|WebChangeEmail whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class WebChangeEmail extends Model
{
    /** @var string */
    protected $primaryKey = 'id';

    /** @var string[] */
    protected $fillable = [
        'id',
        'account_id',
        'email',
        'old_email',
        'change_date',
        'confirmed',
        'confirmation_key',
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
