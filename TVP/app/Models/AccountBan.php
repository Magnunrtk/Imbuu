<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AccountBan
 *
 * @property int $account_id
 * @property string $reason
 * @property int $banned_at
 * @property int $expires_at
 * @property int $banned_by
 * @method static Builder|AccountBan newModelQuery()
 * @method static Builder|AccountBan newQuery()
 * @method static Builder|AccountBan query()
 * @method static Builder|AccountBan whereAccountId($value)
 * @method static Builder|AccountBan whereReason($value)
 * @method static Builder|AccountBan whereBannedAt($value)
 * @method static Builder|AccountBan whereExpiresAt($value)
 * @method static Builder|AccountBan whereBannedBy($value)
 * @mixin \Eloquent
 */

class AccountBan extends Model
{
    public $timestamps = false;
    /** @var string[] */
    protected $primaryKey = 'account_id';
    public $incrementing = false;

    /** @var string[] */
    protected $fillable = [
        'account_id',
        'reason',
        'banned_at',
        'expires_at',
        'banned_by'
    ];

    public function bannedByPlayer()
    {
        return $this->belongsTo(Player::class, 'banned_by', 'id');
    }

    public function player()
    {
        return $this->belongsTo(Player::class, 'account_id', 'account_id')->orderBy('level');
    }

    public function admin()
    {
        return $this->belongsTo(Player::class, 'banned_by', 'id')->orderBy('level');
    }
}
