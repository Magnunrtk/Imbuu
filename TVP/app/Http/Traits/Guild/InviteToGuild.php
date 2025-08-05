<?php

declare(strict_types=1);

namespace App\Http\Traits\Guild;

use App\Models\GuildInvite;
use Illuminate\Database\Eloquent\Model;

trait InviteToGuild {

    public function acceptInvitation(Model $player, Model $guild)
    {
        GuildInvite::create(
            [
                'player_id' => $player->id,
                'guild_id' => $guild->id,
            ],
        );
    }
}