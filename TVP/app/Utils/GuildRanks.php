<?php

declare(strict_types=1);

namespace App\Utils;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GuildRanks
{
    public const LEADER_LEVEL = 1;
    public const VICE_LEADER_LEVEL = 2;
    public const MEMBER_LEVEL = 3;
    public const NO_MEMBER_LEVEL = 0;
    public const MIN_RANKS_AMOUNT = 3;
    public const MAX_RANKS_AMOUNT = 20;
    public const MINIMUM_VICE_LEADERS = 4;

    public static function getHighestRankLevel(Model $guild): int
    {
        $accountGuildMembers = Auth::user()->characters->filter(function ($character) use ($guild) {
            if ($character->guild_membership) {
                return $character->guild_membership->guild_id === $guild->id;
            }
            return false;
        })->pluck('guild_membership.ranks.level')->toArray();
        if(empty($accountGuildMembers)) {
            return self::NO_MEMBER_LEVEL;
        }
        return min($accountGuildMembers);
    }

    public static function guildRankLevelList(Model $guild): array
    {
        if(!Auth::check()) {
            return [];
        }
        return Auth::user()->characters->filter(function ($character) use ($guild) {
            if($character->guild_membership) {
                return $character->guild_membership->guild_id === $guild->id;
            }
            return false;
        })->pluck('guild_membership.ranks.level')->toArray();
    }
}
