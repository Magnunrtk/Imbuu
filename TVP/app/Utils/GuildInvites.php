<?php

declare(strict_types=1);

namespace App\Utils;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GuildInvites
{
    public static function getAccountInvitedCharacterNames(Model $guild): ?array
    {
        if(!Auth::check()) {
            return [];
        }
        return $guild->invitations->filter(function ($guildInvites) {
            return $guildInvites->player->account_id === Auth::user()->id;
        })->pluck('player.name')->toArray();
    }

    public static function getAllInvitedCharacterNames(Model $guild): ?array
    {
        if(!Auth::check()) {
            return [];
        }
        return $guild->invitations->pluck('player.name')->toArray();
    }
}
