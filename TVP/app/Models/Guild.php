<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Guild
 *
 * @property int $id
 * @property string $name
 * @property int $ownerid
 * @property int $creationdata
 * @property string $motd
 * @property int $active
 * @property int $applications_enabled
 * @property-read WebGuild $web_guild
 * @method static Builder|Guild newModelQuery()
 * @method static Builder|Guild newQuery()
 * @method static Builder|Guild query()
 * @method static Builder|Guild whereId($value)
 * @method static Builder|Guild whereName($value)
 * @method static Builder|Guild whereOwnerId($value)
 * @method static Builder|Guild whereCreationdata($value)
 * @method static Builder|Guild whereMotd($value)
 * @method static Builder|Guild whereActive($value)
 * @method static Builder|Guild whereApplicationsEnabled($value)
 * @mixin \Eloquent
 */

class Guild extends Model
{
    public $timestamps = false;

    /** @var string[] */
    protected $fillable = [
        'id',
        'name',
        'ownerid',
        'creationdata',
        'motd',
        'active',
        'applications_enabled',
    ];

    /** @var string[] */
    protected $casts = [
        'applications_enabled' => 'bool',
    ];

    public function owner(): hasOne
    {
        return $this->hasOne(Player::class, 'id', 'ownerid');
    }

    public function resign_leadership(): hasOne
    {
        return $this->hasOne(WebGuildResignLeadership::class, 'guild_id', 'id');
    }

    public function members(): hasMany
    {
        return $this->hasMany(GuildMembership::class, 'guild_id', 'id');
    }

    public function invitations(): hasMany
    {
        return $this->hasMany(GuildInvite::class, 'guild_id', 'id');
    }

    public function ranks(): hasMany
    {
        return $this->hasMany(GuildRank::class, 'guild_id', 'id');
    }

    public function web_guild(): BelongsTo
    {
        return $this->belongsTo(WebGuild::class, 'id', 'guild_id');
    }
}
