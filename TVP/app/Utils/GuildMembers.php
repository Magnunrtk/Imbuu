<?php

declare(strict_types=1);

namespace App\Utils;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GuildMembers
{
    public static function findGuildMember(Model $guild, Model $player): ?Model
    {
        return $guild->members->filter(function ($guildMember) use ($player) {
            return ($guildMember->player_id === $player->id);
        })->first();
    }

    public static function guildMemberList(Model $guild): array
    {
        if(!Auth::check()) {
            return [];
        }
        return Auth::user()->characters->filter(function ($character) use ($guild) {
            if($character->guild_membership) {
                return $character->guild_membership->guild_id === $guild->id;
            }
            return false;
        })->pluck('name')->toArray();
    }
}
