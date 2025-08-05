<?php

declare(strict_types=1);

namespace App\Http\Traits\Guild;

use App\Models\WebGuildApplication;
use App\Utils\GuildApplicationStatus;
use Illuminate\Database\Eloquent\Model;

trait AcceptGuildApplication {

    public function acceptGuildApplication(Model $application)
    {
        $guildApplication = WebGuildApplication::find($application->id);
        $guildApplication->status = GuildApplicationStatus::ACCEPTED;
        $guildApplication->save();
        WebGuildApplication::wherePlayerId($guildApplication->player_id)
            ->whereStatus(GuildApplicationStatus::OPEN)
            ->delete();
    }
}