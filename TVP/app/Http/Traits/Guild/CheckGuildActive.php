<?php

declare(strict_types=1);

namespace App\Http\Traits\Guild;

use App\Models\Guild;
use App\Utils\GuildRanks;

trait CheckGuildActive {

    public function checkActiveStatus(int $guildId)
    {
        $guild = Guild::find($guildId);
        $viceLeaders = 0;
        foreach($guild->members as $member) {
            if($member->ranks->level === GuildRanks::VICE_LEADER_LEVEL) {
                $viceLeaders++;
            }
        }
        if($viceLeaders < GuildRanks::MINIMUM_VICE_LEADERS) {
            $guild->active = false;
        } else {
            $guild->active = true;
        }
        $guild->save();
    }
}