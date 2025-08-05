<?php

declare(strict_types=1);

namespace App\Utils;

class Guild
{
    public static function hasLeaderPrivileges($guildRankLevel): bool
    {
        if(is_array($guildRankLevel)) {
            return in_array(GuildRanks::LEADER_LEVEL, $guildRankLevel);
        }
        return ($guildRankLevel === GuildRanks::LEADER_LEVEL);
    }

    public static function hasViceLeaderPrivileges($guildRankLevel): bool
    {
        if(is_array($guildRankLevel)) {
            return in_array(GuildRanks::VICE_LEADER_LEVEL, $guildRankLevel);
        }
        return ($guildRankLevel === GuildRanks::VICE_LEADER_LEVEL);
    }

    public static function hasMemberPrivileges($guildRankLevel): bool
    {
        if(is_array($guildRankLevel)) {
            return in_array(GuildRanks::MEMBER_LEVEL, $guildRankLevel);
        }
        return ($guildRankLevel === GuildRanks::MEMBER_LEVEL);
    }

    public static function hasLeaderOrViceLeaderPrivileges($guildRankLevel): bool
    {
        if(is_array($guildRankLevel)) {
            return in_array(GuildRanks::LEADER_LEVEL, $guildRankLevel) ||
                in_array(GuildRanks::VICE_LEADER_LEVEL, $guildRankLevel);
        }
        return ($guildRankLevel === GuildRanks::LEADER_LEVEL || $guildRankLevel === GuildRanks::VICE_LEADER_LEVEL);
    }

    public static function hasViceLeaderOrMemberPrivileges($guildRankLevel): bool
    {
        if(is_array($guildRankLevel)) {
            return in_array(GuildRanks::VICE_LEADER_LEVEL, $guildRankLevel) ||
                in_array(GuildRanks::MEMBER_LEVEL, $guildRankLevel);
        }
        return ($guildRankLevel === GuildRanks::VICE_LEADER_LEVEL || $guildRankLevel === GuildRanks::MEMBER_LEVEL);
    }
}
