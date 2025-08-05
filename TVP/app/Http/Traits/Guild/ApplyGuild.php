<?php

declare(strict_types=1);

namespace App\Http\Traits\Guild;

use App\Models\WebGuildApplication;
use App\Utils\GuildApplicationStatus;
use Illuminate\Database\Eloquent\Model;

trait ApplyGuild {

    public function create(Model $player, Model $guild)
    {
        WebGuildApplication::create([
            'player_id' => $player->id,
            'guild_id' => $guild->id,
            'text' => '', //Purifier::clean($text)
            'status' => GuildApplicationStatus::OPEN,
        ]);
    }
}