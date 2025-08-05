<?php

declare(strict_types=1);

namespace App\Http\Traits\Guild;

use App\Models\WebGuildApplication;
use App\Utils\GuildApplicationStatus;
use Illuminate\Database\Eloquent\Model;

trait RejectGuildApplication {

    public function rejectGuildApplication(Model $application)
    {
        $guildApplication = WebGuildApplication::find($application->id);
        $guildApplication->status = GuildApplicationStatus::REJECTED;
        $guildApplication->save();
    }
}