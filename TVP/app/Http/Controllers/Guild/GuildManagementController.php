<?php

declare(strict_types=1);

namespace App\Http\Controllers\Guild;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guilds\GuildManagementRequest;
use App\Http\Traits\Guild\AcceptGuildApplication;
use App\Http\Traits\Guild\CheckGuildActive;
use App\Http\Traits\Guild\DisbandGuild;
use App\Http\Traits\Guild\InviteToGuild;
use App\Http\Traits\Guild\JoinGuild;
use App\Http\Traits\Guild\RejectGuildApplication;
use App\Models\Guild;
use App\Models\GuildInvite;
use App\Models\GuildMembership;
use App\Models\GuildRank;
use App\Models\Player;
use App\Models\WebGuild;
use App\Models\WebGuildApplication;
use App\Utils\FormatText;
use App\Utils\GuildApplicationStatus;
use App\Utils\GuildInvites;
use App\Utils\GuildMembers;
use App\Utils\GuildRanks;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GuildManagementController extends Controller
{
    use CheckGuildActive;
    use JoinGuild;
    use InviteToGuild;
    use DisbandGuild;
    use AcceptGuildApplication;
    use RejectGuildApplication;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function rank(Request $request): View
    {
        $guild = $request->guild;
        $currentGuildRanksAmount = $guild->ranks->count();
        return view('community.view.guild.edit.rank', compact('guild', 'currentGuildRanksAmount'));
    }

    public function updateRankNumber(Request $request, GuildManagementRequest $guildManagementRequest): RedirectResponse
    {
        $guild = $request->guild;
        $requestGuildRankAmount = (int)$guildManagementRequest->input('ranks');
        $currentGuildRanksAmount = $guild->ranks->count();
        $guildRanks = GuildRank::whereGuildId($guild->id);
        $rankDifferenceAmount = abs($requestGuildRankAmount - $currentGuildRanksAmount);
        if ($requestGuildRankAmount > $currentGuildRanksAmount) {
            $ranksToAdd = [];
            $rankOrderId = $guildRanks->get()->max('order_id');
            for ($i = 1; $i <= $rankDifferenceAmount; $i++) {
                $ranksToAdd[] = [
                    'guild_id' => $guild->id,
                    'name' => '(member)',
                    'level' => GuildRanks::MEMBER_LEVEL,
                    'order_id' => $rankOrderId = $rankOrderId + 1,
                ];
            }
            GuildRank::insert($ranksToAdd);
        } else {
            $ranksToRemove = $guildRanks->orderBy('order_id', 'desc')->take($rankDifferenceAmount + 1)->get();
            $demoteRank = $ranksToRemove->pop()->id;
            $rankIdsToRemove = $ranksToRemove->pluck('id')->toArray();
            $rankOrderIdsToRemove = $ranksToRemove->pluck('order_id')->toArray();
            GuildMembership::whereGuildId($guild->id)
                ->whereIn('rank_id', $rankIdsToRemove)
                ->update(['rank_id' => $demoteRank]);
            GuildRank::whereIn('order_id', $rankOrderIdsToRemove)->delete();
        }
        return redirect(route('community.view.guild.manage.rank.index', $guild->name))
            ->with(
                'success',
                'The number of ranks has been changed.',
            );
    }

    public function updateRankName(GuildManagementRequest $request): RedirectResponse
    {
        $guild = $request->guild;
        if ($this->countVowel($request->input('newRankName')) === 0) {
            return redirect(route('community.view.guild.manage.rank.index', [$guild->name]))
                ->with(
                    'error',
                    'This name contains a word without vowels. Please choose another name.'
                );
        }
        $checkGuildRankName = FormatText::checkTextFormat($request->input('newRankName'), 'name');
        if (!empty($checkGuildRankName)) {
            return redirect(route('community.view.guild.manage.rank.index', [$guild->name]))
                ->with(
                    'error',
                    $checkGuildRankName
                );
        }
        $guildRank = GuildRank::whereGuildId($guild->id)->whereOrderId($request->input('rank_id'))->first();
        if (is_null($guildRank)) {
            return redirect(route('community.view.guild.manage.rank.index', [$guild->name]))
                ->with(
                    'error',
                    'Invalid rank selection.'
                );
        }
        $guildRank->name = $request->input('newRankName');
        $guildRank->save();
        return redirect(route('community.view.guild.manage.rank.index', [$guild->name]))
            ->with(
                'success',
                'The rank name has been changed.',
            );
    }

    private function countVowel(string $name): int
    {
        $checkName = Str::lower($name);
        return substr_count($checkName, 'a') + substr_count($checkName, 'e') +
            substr_count($checkName, 'i') + substr_count($checkName, 'o') +
            substr_count($checkName, 'u') + substr_count($checkName, 'y');
    }

    public function member(Request $request): View
    {
        $guild = $request->guild;
        $guildLevelRank = GuildRanks::guildRankLevelList($guild);
        return view('community.view.guild.edit.member', compact('guild', 'guildLevelRank'));
    }

    public function memberAction(GuildManagementRequest $request): RedirectResponse
    {
        $guild = $request->guild;
        return match ((int)$request->input('action')) {
            1 => $this->editRankName($request),
            2 => $this->title($request),
            3 => $this->exclude($request),
            default => redirect(route('community.view.guild.index', [$guild->name]))
                ->with(
                    'error',
                    'Please select an action.'
                ),
        };
    }

    private function editRankName(GuildManagementRequest $request): RedirectResponse
    {
        $guild = $request->guild;
        $targetGuildRankId = (int)$request->input('rank_id');
        $playerHighestRank = GuildRanks::getHighestRankLevel($guild);
        if (!in_array($targetGuildRankId, $guild->ranks->pluck('order_id')->toArray())) {
            return redirect(route('community.view.guild.manage.member.index', [$guild->name]))
                ->with(
                    'error',
                    'Invalid rank selection.'
                );
        }
        $targetRank = GuildRank::whereGuildId($guild->id)->whereOrderId($targetGuildRankId)->first();
        $targetCharacter = Player::whereName($request->input('character'))->first();
        $targetGuildMember = GuildMembers::findGuildMember($guild, $targetCharacter);
        if (is_null($targetGuildMember)) {
            return redirect(route('community.view.guild.manage.member.index', [$guild->name]))
                ->with(
                    'error',
                    'Character was not found.'
                );
        }
        if ($targetGuildMember->ranks->level <= $playerHighestRank) {
            return redirect(route('community.view.guild.manage.member.index', [$guild->name]))
                ->with(
                    'error',
                    'You may only promote or demote members with a lower rank than yours.'
                );
        }
        if ($targetRank->level <= $playerHighestRank) {
            return redirect(route('community.view.guild.manage.member.index', [$guild->name]))
                ->with(
                    'error',
                    'You may only promote or demote members with a lower rank than yours.'
                );
        }
        $holdsHighestRank = false;
        if ($targetRank->level === GuildRanks::LEADER_LEVEL || $targetRank->level === GuildRanks::VICE_LEADER_LEVEL) {
            foreach ($targetCharacter->account->characters as $character) {
                if ($character->guild_membership &&
                    $character->guild_membership->ranks->level === GuildRanks::LEADER_LEVEL ||
                    $character->guild_membership &&
                    $character->guild_membership->ranks->level === GuildRanks::VICE_LEADER_LEVEL) {
                    $holdsHighestRank = true;
                }
            }
        }

        if ($holdsHighestRank) {
            if ($targetCharacter->account->id === Auth::user()->id) {
                $errorMsg = 'A character of your account already holds one of the two highest ranks in another guild.';
            } else {
                $errorMsg = 'A character of this account already holds one of the two highest ranks in some guild.';
            }
            return redirect(route('community.view.guild.manage.member.index', [$guild->name]))
                ->with(
                    'error',
                    $errorMsg
                );
        }
        $targetGuildMember->rank_id = $targetRank->id;
        $targetGuildMember->save();

        $guild = Guild::find($guild->id);
        $viceLeaders = 0;
        foreach ($guild->members as $member) {
            if ($member->ranks->level === GuildRanks::VICE_LEADER_LEVEL) {
                $viceLeaders++;
            }
        }
        if ($viceLeaders >= GuildRanks::MINIMUM_VICE_LEADERS) {
            $guild->active = true;
        } else {
            $guild->active = false;
        }
        $guild->save();

        return redirect(route('community.view.guild.manage.member.index', [$guild->name]))
            ->with(
                'success',
                sprintf('%s\'s rank has been changed.', $targetCharacter->name),
            );
    }

    private function title(GuildManagementRequest $request): RedirectResponse
    {
        $guild = $request->guild;
        $title = $request->input('title');
        $targetCharacter = Player::whereName($request->input('character'))->first();
        $targetGuildMember = GuildMembers::findGuildMember($guild, $targetCharacter);
        if (is_null($targetGuildMember)) {
            return redirect(route('community.view.guild.manage.member.index', [$guild->name]))
                ->with(
                    'error',
                    'Character is not a member of this guild.'
                );
        }
        if (empty($title)) {
            $targetGuildMember->nick = '';
            $targetGuildMember->save();
            return redirect(route('community.view.guild.manage.member.index', [$guild->name]))
                ->with(
                    'success',
                    sprintf(
                        '%s\\\'s title has been removed.',
                        $targetCharacter->name
                    ),
                );
        }
        $titleToSetCorrect = FormatText::checkTextFormat($title, 'title');
        if (!empty($titleToSetCorrect)) {
            return redirect(route('community.view.guild.manage.member.index', [$guild->name]))
                ->with(
                    'error',
                    $titleToSetCorrect
                );
        }
        $targetGuildMember->nick = $title;
        $targetGuildMember->save();
        return redirect(route('community.view.guild.manage.member.index', [$guild->name]))
            ->with(
                'success',
                sprintf(
                    '%s has been conferred the title "%s".',
                    $targetCharacter->name, $title
                ),
            );
    }

    private function exclude(GuildManagementRequest $request): RedirectResponse
    {
        $guild = $request->guild;
        $targetCharacter = Player::whereName($request->input('character'))->first();
        $targetGuildMember = GuildMembers::findGuildMember($guild, $targetCharacter);
        if (is_null($targetGuildMember)) {
            return redirect(route('community.view.guild.manage.member.index', [$guild->name]))
                ->with(
                    'error',
                    'Character is not a member of this guild.'
                );
        }
        $playerHighestRank = GuildRanks::getHighestRankLevel($guild);
        if ($targetGuildMember->ranks->level <= $playerHighestRank) {
            return redirect(route('community.view.guild.manage.member.index', [$guild->name]))
                ->with(
                    'error',
                    'You may only exclude members with a lower rank than yours.'
                );
        }
        $targetGuildMember->delete();
        return redirect(route('community.view.guild.manage.member.index', [$guild->name]))
            ->with(
                'success',
                sprintf('%s has been excluded.', $targetCharacter->name),
            );
    }

    public function leave(Request $request): View
    {
        $guild = $request->guild;
        $accountGuildMembers = GuildMembers::guildMemberList($guild);
        return view('community.view.guild.edit.leave', compact('guild', 'accountGuildMembers'));
    }

    public function leaveAction(GuildManagementRequest $request): RedirectResponse
    {
        $guild = $request->guild;
        $player = Player::whereName($request->input('character'))->first();
        if (\App\Utils\Guild::hasLeaderPrivileges($player->guild_membership->ranks->level)) {
            return redirect(route('community.view.guild.manage.leave.index', [$guild->name]))
                ->with(
                    'error',
                    'As the leader of this guild, you may not leave. You will either have to resign or to disband the guild.'
                );
        }
        $guildId = $player->guild_membership->guild_id;
        $player->guild_membership->delete();
        $this->checkActiveStatus($guildId);
        return redirect(route('community.view.guild.index', $guild->name))
            ->with(
                'success',
                'You successfully left the guild.'
            );
    }

    public function join(Request $request): RedirectResponse|View
    {
        $guild = $request->guild;
        $invitedPlayers = GuildInvites::getAccountInvitedCharacterNames($guild);
        return view('community.view.guild.edit.join', compact('guild', 'invitedPlayers'));
    }

    public function joinAction(GuildManagementRequest $request): RedirectResponse
    {
        $guild = $request->guild;
        $player = Player::whereName($request->input('character'))->first();
        $guildInvitation = GuildInvite::find($player->id);
        if (is_null($guildInvitation)) {
            return redirect(route('community.view.guild.manage.join.index', [$guild->name]))
                ->with(
                    'error',
                    'You do not have an invitation for this guild.'
                );
        }
        $this->joinGuild($player, $guild, $guildInvitation);
        $this->checkActiveStatus($guild->id);
        return redirect(route('community.view.guild.index', [$guild->name]))
            ->with(
                'success',
                'You successfully joined the guild.'
            );
    }

    public function invite(Request $request): View
    {
        $guild = $request->guild;
        $invitedPlayers = GuildInvites::getAllInvitedCharacterNames($guild);
        return view('community.view.guild.edit.invite', compact('guild', 'invitedPlayers'));
    }

    public function inviteAction(GuildManagementRequest $request): RedirectResponse
    {
        $guild = $request->guild;
        $player = Player::whereName($request->input('character'))->first();
        $hasGuildInvite = GuildInvite::wherePlayerId($player->id)->whereGuildId($guild->id)->exists();
        if ($hasGuildInvite) {
            return redirect(route('community.view.guild.manage.invite.index', [$guild->name]))
                ->with(
                    'error',
                    'Player has already an invitation to this guild!'
                );
        }
        $this->acceptInvitation($player, $guild);
        return redirect(route('community.view.guild.manage.invite.index', [$guild->name]))
            ->with(
                'success',
                sprintf('%s has been invited.', $player->name)
            );
    }

    public function cancelInvite(GuildManagementRequest $request): RedirectResponse
    {
        $guild = $request->guild;
        $player = Player::whereName($request->input('character'))->first();
        $guildInvitation = GuildInvite::wherePlayerId($player->id)->whereGuildId($guild->id)->first();
        if (is_null($guildInvitation)) {
            return redirect(route('community.view.guild.manage.invite.index', [$guild->name]))
                ->with(
                    'error',
                    'This character has not been invited.'
                );
        }
        $guildInvitation->delete();
        return redirect(route('community.view.guild.manage.invite.index', [$guild->name]))
            ->with(
                'success',
                sprintf('The invitation of %s has been cancelled.', $player->name)
            );
    }

    public function disband(Request $request): View
    {
        $guild = $request->guild;
        return view('community.view.guild.edit.disband', compact('guild'));
    }

    public function disbandAction(GuildManagementRequest $request): RedirectResponse
    {
        $guild = $request->guild;
        $this->deleteGuild($guild);
        return redirect(route('community.guilds.index'))
            ->with(
                'success',
                sprintf('You have disbanded the %s', $guild->name)
            );
    }

    public function applications(Request $request): View
    {
        $guild = $request->guild;
        $guildLevelRank = GuildRanks::guildRankLevelList($guild);
        $guildApplications = WebGuildApplication::whereGuildId($guild->id)->orderBy('created_at', 'desc')->get();
        return view(
            'community.view.guild.application.requested.index',
            compact(
                'guild',
                'guildLevelRank',
                'guildApplications',
            )
        );
    }

    public function denyApplications(GuildManagementRequest $request): RedirectResponse
    {
        $guild = $request->guild;
        $guild->applications_enabled = false;
        $guild->save();
        return redirect(route('community.view.guild.manage.applications.index', [$guild->name]))
            ->with(
                'success',
                'You have closed your guild for applications.'
            );
    }

    public function allowApplications(Request $request): RedirectResponse
    {
        $guild = $request->guild;
        $guild->applications_enabled = true;
        $guild->save();
        return redirect(route('community.view.guild.manage.applications.index', [$guild->name]))
            ->with(
                'success',
                'You have opened your guild for applications.'
            );
    }

    public function acceptApplication(Request $request, string $guildName, string $name): RedirectResponse
    {
        $guild = $request->guild;
        $messages = [
            'guildName.required' => 'Guild was not found.',
            'guildName.guild_rank_level' => 'Only guild leader and vices can change application status!',
            'name.required' => 'Character was not found.',
            'name.character_exists' => 'Character was not found.',
            'name.has_no_guild' => 'This character is already a member of a guild.',
        ];
        $rules = [
            'guildName' => 'bail|required|guild_rank_level:' . GuildRanks::VICE_LEADER_LEVEL,
            'name' => 'bail|required|character_exists|has_no_guild',
        ];
        $validator = Validator::make($request->route()->parameters(), $rules, $messages);
        if ($validator->fails()) {
            return redirect(route('community.view.guild.manage.applications.index', [$guild->name]))
                ->with(
                    'error',
                    preg_replace('/\s+/', ' ', $validator->errors()->first())
                );
        }
        $characterName = str_replace('+', ' ', $name);
        $player = Player::whereName(trim(strtolower($characterName)))->first();
        $application = WebGuildApplication::wherePlayerId($player->id)
            ->whereGuildId($guild->id)
            ->whereStatus(GuildApplicationStatus::OPEN)
            ->first();
        if (is_null($application)) {
            return redirect(route('community.view.guild.manage.applications.index', [$guild->name]))
                ->with(
                    'error',
                    'Guild application does not exists.'
                );
        }
        $this->acceptGuildApplication($application);
        $this->joinGuild($player, $guild);
        $this->checkActiveStatus($guild->id);
        return redirect(route('community.view.guild.manage.applications.index', [$guild->name]))
            ->with(
                'success',
                'You accepted the application.'
            );
    }

    public function rejectApplication(Request $request, string $guildName, string $name): RedirectResponse
    {
        $guild = $request->guild;
        $messages = [
            'guildName.required' => 'Guild was not found.',
            'guildName.guild_rank_level' => 'Only guild leader and vices can change application status!',
            'name.required' => 'Character was not found.',
            'name.character_exists' => 'Character was not found.',
            'name.has_no_guild' => 'This character is already a member of a guild.',
        ];
        $rules = [
            'guildName' => 'bail|required|guild_rank_level:' . GuildRanks::VICE_LEADER_LEVEL,
            'name' => 'bail|required|character_exists|has_no_guild',
        ];
        $validator = Validator::make($request->route()->parameters(), $rules, $messages);
        if ($validator->fails()) {
            return redirect(route('community.view.guild.manage.applications.index', [$guild->name]))
                ->with(
                    'error',
                    preg_replace('/\s+/', ' ', $validator->errors()->first())
                );
        }
        $characterName = str_replace('+', ' ', $name);
        $player = Player::whereName(trim(strtolower($characterName)))->first();
        $application = WebGuildApplication::wherePlayerId($player->id)
            ->whereGuildId($guild->id)
            ->whereStatus(GuildApplicationStatus::OPEN)
            ->first();
        if (is_null($application)) {
            return redirect(route('community.view.guild.manage.applications.index', [$guild->name]))
                ->with(
                    'error',
                    'Guild application does not exists.'
                );
        }
        $this->rejectGuildApplication($application);
        return redirect(route('community.view.guild.manage.applications.index', [$guild->name]))
            ->with(
                'success',
                'You rejected the application.'
            );
    }

    public function edit(Request $request): View|RedirectResponse
    {
        $guild = $request->guild;
        if (!$guild->active) {
            return redirect(route('community.view.guild.index', [$guild->name]));
        }
        return view('community.view.guild.edit.description', compact('guild'));
    }

    public function descriptionAction(GuildManagementRequest $request): RedirectResponse
    {
        $guild = $request->guild;
        if (!$guild->active) {
            return redirect(route('community.view.guild.index', [$guild->name]));
        }
        $webGuild = WebGuild::whereGuildId($guild->id)->first();
        if ($webGuild) {
            $webGuild->description = $request->input('description');
            $webGuild->save();
        }

        return redirect(route('community.view.guild.manage.edit.index', [$guild->name]))
            ->with(
                'success',
                'The description of your guild has been changed.'
            );
    }

    public function logoAction(GuildManagementRequest $request): RedirectResponse
    {
        $guild = $request->guild;
        if (is_null($request->file('logo')) || !$guild->active) {
            return redirect(route('community.view.guild.manage.edit.index', [$guild->name]));
        }

        $logoFileName = 'guild_' . $guild->id . '.' . $request->file('logo')->getClientOriginalExtension();
        $path = $request->file('logo')->storeAs('', $logoFileName, 'guild_logos');
        if (Storage::disk('guild_logos')->exists($logoFileName)) {
            $webGuild = WebGuild::whereGuildId($guild->id)->first();
            if ($webGuild) {
                $webGuild->logo_name = $logoFileName;
                $webGuild->save();
            }
            return redirect(route('community.view.guild.manage.edit.index', [$guild->name]))
                ->with(
                    'success',
                    'The logo of your guild has been changed. It can take up to 15 minutes until the change of your logo takes effect. Please be patient.'
                );
        } else {
            //For linux system there might be permission issues
            return redirect(route('community.view.guild.manage.edit.index', [$guild->name]))
                ->with('error', 'Failed to save the logo file. Please try again.');
        }
    }
}
