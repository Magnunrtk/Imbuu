<?php

declare(strict_types=1);

namespace App\Http\Traits\Guild;

use App\Models\GuildMembership;
use App\Models\WebGuildApplication;
use App\Utils\GuildApplicationStatus;
use Illuminate\Database\Eloquent\Model;

trait JoinGuild {

    public function joinGuild(Model $player, Model $guild, Model $guildInvitation = null)
    {
        $hadGuildApplication = WebGuildApplication::wherePlayerId($player->id)
            ->whereGuildId($guild->id)
            ->whereStatus(GuildApplicationStatus::OPEN)
            ->first();
        if(!is_null($hadGuildApplication)) {
            $hadGuildApplication->status = GuildApplicationStatus::ACCEPTED;
            $hadGuildApplication->save();
        }
        WebGuildApplication::wherePlayerId($player->id)->whereStatus(GuildApplicationStatus::OPEN)->delete();
        if(!is_null($guildInvitation)) {
            $guildInvitation->delete();
        }
        GuildMembership::create(
            [
                'player_id' => $player->id,
                'guild_id' => $guild->id,
                'rank_id' => $guild->ranks->pop()->id,
            ],
        );
    }
}