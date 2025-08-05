<?php

declare(strict_types=1);

namespace App\Http\Traits\Guild;

use App\Models\WebGuildApplication;
use Illuminate\Database\Eloquent\Model;

trait DisbandGuild {

    public function deleteGuild(Model $guild)
    {
        $guild->delete();
        WebGuildApplication::whereGuildId($guild->id)->delete();
    }
}