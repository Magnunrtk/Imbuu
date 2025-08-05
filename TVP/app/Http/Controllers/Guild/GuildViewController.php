<?php

declare(strict_types=1);

namespace App\Http\Controllers\Guild;

use App\Http\Controllers\Controller;
use App\Utils\GuildApplications;
use App\Utils\GuildInvites;
use App\Utils\GuildMembers;
use App\Utils\GuildRanks;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuildViewController extends Controller
{
    public function view(Request $request): View
    {
        $guild = $request->guild;
        $invitedPlayers = GuildInvites::getAccountInvitedCharacterNames($guild);
        $guildLevelRank = GuildRanks::guildRankLevelList($guild);
        $applyAbleCharacters = GuildApplications::getGuildApplicationCharacters($guild);
        $accountGuildMembers = GuildMembers::guildMemberList($guild);
        return view(
            'community.view.guild.index',
            compact(
                'guild',
                'invitedPlayers',
                'guildLevelRank',
                'applyAbleCharacters',
                'accountGuildMembers',
            )
        );
    }
}
