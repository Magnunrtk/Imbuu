<?php

declare(strict_types=1);

namespace App\Http\Traits\Guild;

use App\Models\Guild;
use App\Models\GuildMembership;
use App\Models\GuildRank;
use App\Models\WebGuild;
use App\Models\WebGuildApplication;
use App\Utils\GuildApplicationStatus;
use App\Utils\GuildRanks;
use Illuminate\Database\Eloquent\Model;

trait CreateGuild {

    public function store(Model $owner, $name)
    {
        $guild = Guild::create(
            [
                'name' => $name,
                'ownerid' => $owner->id,
                'creationdata' => time(),
            ]
        );
        WebGuild::create([
            'guild_id' => $guild->id,
            'logo_name' => 'default_logo.gif',
        ]);
        $leaderRank = GuildRank::create(
            [
                'guild_id' => $guild->id,
                'name' => 'Leader',
                'level' => GuildRanks::LEADER_LEVEL,
                'order_id' => 1,
            ]
        );
        GuildRank::create(
            [
                'guild_id' => $guild->id,
                'name' => 'Vice Leader',
                'level' => GuildRanks::VICE_LEADER_LEVEL,
                'order_id' => 2,
            ],
        );
        GuildRank::create(
            [
                'guild_id' => $guild->id,
                'name' => 'Member',
                'level' => GuildRanks::MEMBER_LEVEL,
                'order_id' => 3,
            ],
        );
        GuildMembership::create(
            [
                'player_id' => $owner->id,
                'guild_id' => $guild->id,
                'rank_id' => $leaderRank->id,
            ],
        );
        WebGuildApplication::wherePlayerId($owner->id)->whereStatus(GuildApplicationStatus::OPEN)->delete();
    }
}