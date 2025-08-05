<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\WebLostAccount
 *
 * @property int $id
 * @property int $account_id
 * @property string $email
 * @property string $confirmation_key
 * @property mixed $created_at
 * @property Carbon $updated_at
 * @method static Builder|WebLostAccount newModelQuery()
 * @method static Builder|WebLostAccount newQuery()
 * @method static Builder|WebLostAccount query()
 * @method static Builder|WebLostAccount whereId($value)
 * @method static Builder|WebLostAccount whereAccountId($value)
 * @method static Builder|WebLostAccount whereEmail($value)
 * @method static Builder|WebLostAccount whereConfirmationKey($value)
 * @method static Builder|WebLostAccount whereCreatedAt($value)
 * @method static Builder|WebLostAccount whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class WebLostAccount extends Model
{
    protected $table = 'web_lost_account';
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
