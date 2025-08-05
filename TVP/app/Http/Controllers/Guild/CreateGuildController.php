<?php

declare(strict_types=1);

namespace App\Http\Controllers\Guild;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guilds\CreateGuildRequest;
use App\Http\Traits\Guild\CreateGuild;
use App\Models\Player;
use App\Utils\FormatText;
use App\Utils\Guild;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CreateGuildController extends Controller
{
    use CreateGuild;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        return view('community.guild.create.index');
    }

    public function create(CreateGuildRequest $request): RedirectResponse
    {
        $checkGuildName = FormatText::checkTextFormat($request->input('guildName'), 'guild name');
        if (!empty($checkGuildName)) {
            return redirect(route('community.guild.create.index'))
                ->with(
                    'error',
                    $checkGuildName
                );
        }
        $guildName = $request->input('guildName');
        $leaderPlayer = Player::whereName($request->input('character'))
            ->with(
                'account',
                'account.characters',
                'account.characters.guild_membership',
                'account.characters.guild_membership.ranks'
            )->first();

        if(config('guilds.needPremiumAccountToCreateGuild') && !Auth::user()->isAdmin()) {
            if (!$leaderPlayer->account->isPremium()) {
                return redirect(route('community.guild.create.index'))
                    ->with(
                        'error',
                        'You do not have Premium Time on your account.'
                    );
            }
        }

        if (!Auth::user()->isAdmin() && $leaderPlayer->level < config('guilds.levelToCreateGuild')) {
            return redirect(route('community.guild.create.index'))
                ->with(
                    'error',
                    sprintf(
                        'Your character needs to be at least level %d to create a guild.',
                        config('guilds.create_level')
                    )
                );
        }
        foreach ($leaderPlayer->account->characters as $accountCharacter) {
            if($accountCharacter->guild_membership && $accountCharacter->guild_membership->ranks &&
                Guild::hasLeaderPrivileges($accountCharacter->guild_membership->ranks->level) ||
                $accountCharacter->guild_membership && $accountCharacter->guild_membership->ranks &&
                Guild::hasViceLeaderPrivileges($accountCharacter->guild_membership->ranks->level)) {
                $errorMsg = 'A character of your account already holds one of the two highest ranks in another guild.';
                return redirect(route('community.guild.create.index'))
                    ->with(
                        'error',
                        $errorMsg
                    );
            }
        }
        $this->store($leaderPlayer, $guildName);
        return redirect(route('community.view.guild.index', [$guildName]))
            ->with(
                'success',
                sprintf('You have founded the %s. Now go ahead and invite the first members. 
                Note that the guild will be deleted if it does not become active within three days.', $guildName)
            );
    }
}
