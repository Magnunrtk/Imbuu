<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Player
 *
 * @property int $id
 * @property string $name
 * @property int $group_id
 * @property int $account_id
 * @property int $level
 * @property int $vocation
 * @property int $town_id
 * @property string $conditions
 * @property int $lookbody
 * @property int $lookfeet
 * @property int $lookhead
 * @property int $looklegs
 * @property int $looktype
 * @property int $health
 * @property int $healthmax
 * @property int $mana
 * @property int $manamax
 * @property int $cap
 * @property int $balance
 * @property int $hidden
 * @property Carbon $created_at
 * @method static Builder|Player newModelQuery()
 * @method static Builder|Player newQuery()
 * @method static Builder|Player query()
 * @method static Builder|Player whereId($value)
 * @method static Builder|Player whereName($value)
 * @method static Builder|Player whereGroupId($value)
 * @method static Builder|Player whereAccountId($value)
 * @method static Builder|Player whereLevel($value)
 * @method static Builder|Player whereVocation($value)
 * @method static Builder|WebAccounts whereCreatedAt($value)
 * @mixin \Eloquent
 */

class Player extends Model
{
    public $timestamps = false;
    /** @var string */
    protected $primaryKey = 'id';

    /** @var string[] */
    protected $fillable = [
        'id',
        'name',
        'sex',
        'account_id',
        'group_id',
        'account_id',
        'level',
        'vocation',
        'town_id',
        'conditions',
        'lookbody',
        'lookfeet',
        'lookhead',
        'looklegs',
        'looktype',
        'health',
        'healthmax',
        'mana',
        'manamax',
        'cap',
        'balance',
        'lastlogin',
    ];

    /** @var string[] */
    protected $hidden = [
        'id',
    ];

    /** @var string[] */
    protected $casts = [
        'hidden' => 'bool',
    ];

    public function online(): hasOne
    {
        return $this->hasOne(PlayersOnline::class, 'player_id', 'id');
    }

    public function list(): hasMany
    {
        return $this->hasMany($this, 'account_id', 'account_id');
    }

    public function account(): hasOne
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }

    public function webaccount(): hasOne
    {
        return $this->hasOne(WebAccounts::class, 'account_id', 'account_id');
    }

    public function guild_membership(): hasOne
    {
        return $this->hasOne(GuildMembership::class, 'player_id', 'id');
    }

    public function guild_owner(): hasOne
    {
        return $this->hasOne(Guild::class, 'ownerid', 'id');
    }

    public function guild_invitations(): hasMany
    {
        return $this->hasMany(GuildInvite::class, 'player_id', 'id');
    }

    public function deaths(): hasMany
    {
        return $this->hasMany(PlayerDeath::class, 'player_id', 'id')
            ->orderBy('time', 'desc')->limit(15);
    }

    public function house(): hasOne
    {
        return $this->hasOne(House::class, 'owner', 'id');
    }

    public static function create(array $attributes = [], int $accountId = null)
    {
        $accountId = is_null($accountId) ? Auth::user()->id : $accountId;
        $outfitLookType = (int) $attributes['sex'] === 1 ?
            config('new_player.outfit.looktype.male') :
            config('new_player.outfit.looktype.female');
        $attributes = array_merge($attributes,
            [
                'account_id' => $accountId,
                'conditions' => '',
                'town_id' => config('new_player.town_id'),
                'lookbody' => config('new_player.outfit.lookbody'),
                'lookfeet' => config('new_player.outfit.lookfeet'),
                'lookhead' => config('new_player.outfit.lookhead'),
                'looklegs' => config('new_player.outfit.looklegs'),
                'looktype' => $outfitLookType,
                'health' => config('new_player.health'),
                'healthmax' => config('new_player.healthmax'),
                'mana' => config('new_player.mana'),
                'manamax' => config('new_player.manamax'),
                'cap' => config('new_player.cap')
            ]
        );
        return static::query()->create($attributes);
    }
}
