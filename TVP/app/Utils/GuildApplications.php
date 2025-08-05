<?php

declare(strict_types=1);

namespace App\Utils;

use App\Models\WebGuildApplication;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GuildApplications
{
    public static function getGuildApplicationCharacters(Model $guild)
    {
        if(!Auth::check()) {
            return [];
        }
        return Auth::user()->characters->filter(function ($character) use ($guild) {
            if($character->guild_membership ||
                array_search($guild->id, array_column($character->guild_invitations->toArray(), 'guild_id'))
                || GuildApplications::hasApplied($guild->id, $character->id)) {
                return false;
            }
            return $character;
        })->pluck('name')->toArray();
    }

    public static function hasGuildApplications(Model $guild): bool
    {
        return WebGuildApplication::whereIn('player_id', Auth::user()->characters->pluck('id')->toArray())
            ->whereGuildId($guild->id)
            ->exists();
    }

    public static function hasApplied(int $guildId, int $playerId): bool
    {
        return WebGuildApplication::whereGuildId($guildId)
            ->wherePlayerId($playerId)->exists();
    }

    public static function hasAppliedBefore(int $guildId, int $playerId): bool
    {
        return WebGuildApplication::wherePlayerId($playerId)
            ->whereGuildId($guildId)
            ->whereStatus(GuildApplicationStatus::OPEN)
            ->whereStatus(GuildApplicationStatus::REJECTED)
            ->where('created_at', '>', now()->subDays(30)->endOfDay())
            ->exists();
    }

}
