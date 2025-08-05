<?php

declare(strict_types=1);

namespace App\Http\Controllers\Guild;

use App\Http\Controllers\Controller;
use App\Models\Guild;
use App\Models\Player;
use App\Models\WebGuildResignLeadership;
use App\Utils\FormatText;
use App\Utils\GuildMembers;
use App\Utils\GuildRanks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use function redirect;
use function response;

class ResignGuildLeadershipController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function resign(Request $request)
    {
        $request->request->add(['name' => $request->input('guildName')]);
        $messages = [
            'name.required' => 'Guild was not found.',
            //'name.guild_exists' => 'Guild was not found.',
            'name.guild_rank_level' => 'You are not the owner of this guild!',
            'password.required' => 'The password is required.',
            'password.string' => 'The password format is invalid.',
            'character.required' => 'Character was not found.',
            'character.character_exists' => 'Character was not found.',
            'character.has_guild' => 'This character has no guild.',
        ];
        $rules = [
            'name' => 'bail|required|guild_rank_level:'. GuildRanks::LEADER_LEVEL,
            'password' => 'required|string',
            'character' => 'bail|required|character_exists',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'type' => 'error',
                    'title' => 'Error!',
                    'message' => $validator->errors()->first()
                ]
            );
        }
        if(!Hash::check($request->input('password'), Auth::user()->password)) {
            return response()->json(
                [
                    'success' => false,
                    'type' => 'error',
                    'title' => 'Error!',
                    'message' => 'The password you have entered is not correct!'
                ]
            );
        }
        $guildRankName = $request->input('name');
        $checkGuildRankName = FormatText::checkTextFormat($guildRankName, 'name');
        if (!empty($checkGuildRankName)) {
            return redirect(route('community.guild.create.index'))
                ->with(
                    'error',
                    $checkGuildRankName
                );
        }
        $guild = Guild::whereRaw('LOWER(`name`) LIKE ? ',[trim(strtolower($request->input('name')))])->first();
        $player = Player::whereRaw('LOWER(`name`) LIKE ? ',[trim(strtolower($request->input('character')))])->first();
        if(is_null(GuildMembers::findGuildMember($guild, $player))) {
            return response()->json(
                [
                    'success' => false,
                    'type' => 'error',
                    'title' => 'Error!',
                    'message' => sprintf('%s is no member of your guild.', $player->name),
                ]
            );
        }
        if($guild->owner->id === $player->id) {
            return response()->json(
                [
                    'success' => false,
                    'type' => 'error',
                    'title' => 'Error!',
                    'message' => sprintf(
                        '%s is already the leader of this guild.', $player->name
                    ),
                ]
            );
        }

        $holdsHighestRank = false;
        foreach ($player->account->characters as $character) {
            if($character->guild_membership &&
                \App\Utils\Guild::hasLeaderPrivileges($character->guild_membership->ranks->level) ||
                $character->guild_membership &&
                \App\Utils\Guild::hasViceLeaderPrivileges(GuildRanks::VICE_LEADER_LEVEL)) {
                $holdsHighestRank = true;
            }
        }
        if($holdsHighestRank) {
            if($player->account->id === Auth::user()->id) {
                $errorMsg = 'A character of your account already holds one of the two highest ranks in a guild.';
            } else {
                $errorMsg = 'A character of this account already holds one of the two highest ranks in some guild.';
            }
            return response()->json(
                [
                    'success' => false,
                    'type' => 'error',
                    'title' => 'Error!',
                    'message' => $errorMsg
                ]
            );
        }
        $leadershipResign = WebGuildResignLeadership::whereGuildId($guild->id)->first();
        if($leadershipResign) {
            $leadershipResign->delete();
        }
        WebGuildResignLeadership::create(
            [
                'player_id' => $guild->owner->id,
                'guild_id' => $guild->id,
                'new_player_id' => $player->id,
            ]
        );
        return response()->json(
            [
                'success' => true,
                'type' => 'success',
                'title' => 'Done!',
                'message' => sprintf(
                    'You have offered your resignation. %s has to accept the leadership. 
                    If you own or bid for a guildhall, it will be transferred to the new leader, too.',
                    $guild->name
                )
            ]
        );
    }
}
