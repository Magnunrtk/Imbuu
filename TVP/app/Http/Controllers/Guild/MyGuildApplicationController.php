<?php

declare(strict_types=1);

namespace App\Http\Controllers\Guild;

use App\Http\Controllers\Controller;
use App\Http\Traits\Guild\ApplyGuild;
use App\Models\Player;
use App\Models\WebGuildApplication;
use App\Utils\GuildApplications;
use App\Utils\GuildApplicationStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MyGuildApplicationController extends Controller
{
    use ApplyGuild;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request): RedirectResponse|View
    {
        $guild = $request->guild;
        $guildApplications = WebGuildApplication::whereIn('player_id', Auth::user()->characters->pluck('id')->toArray())
            ->whereGuildId($guild->id)->orderBy('created_at', 'desc')->get();
        if (!$guild->applications_enabled && $guildApplications->isEmpty()) {
            return redirect(route('community.view.guild.index', [Str::strToUrl($guild->name)]));
        }
        return view(
            'community.view.guild.application.applied.index',
            compact(
                'guild',
                'guildApplications'
            )
        );
    }

    public function store(Request $request): RedirectResponse
    {
        $guild = $request->guild;
        $request->request->add(['name' => $guild->name]);
        $messages = [
            'name.required' => 'Guild was not found.',
            'character.required' => 'Character was not found.',
            'character.character_exists' => 'Character was not found.',
            'character.character_on_account' => 'This character does not belong to your account.',
            'character.has_no_guild' => 'This character is already a member of a guild.',
        ];
        $rules = [
            'name' => 'bail|required',
            'character' => 'bail|required|character_on_account|character_exists|has_no_guild',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect(route('community.view.guild.my.applications.index', [Str::strToUrl($guild->name)]))
                ->with(
                    'error',
                    preg_replace('/\s+/', ' ', $validator->errors()->first())
                );
        }
        $player = Player::whereRaw('LOWER(`name`) LIKE ? ',[trim(strtolower($request->input('character')))])->first();
        $cannotApply = $this->canApply($player, $guild);
        if(!empty($cannotApply)) {
            return redirect(route('community.view.guild.my.applications.index', [Str::strToUrl($guild->name)]))
                ->with(
                    'error',
                    $cannotApply['message']
                );
        }

        $this->create($player, $guild);

        return redirect(route('community.view.guild.my.applications.index', [Str::strToUrl($guild->name)]))
            ->with(
                'success',
                'Your application has been successfully submitted.'
            );
    }

    public function withdraw(Request $request, string $guildName, $name): RedirectResponse
    {
        $guild = $request->guild;
        $characterName = str_replace('+', ' ', $name);
        $player = Player::whereName(trim(strtolower($characterName)))->first();
        if ($player->account_id !== Auth::user()->id) {
            return redirect(route('community.view.guild.my.applications.index', [Str::strToUrl($guild->name)]))
                ->with(
                    'error',
                    'Character does not belong to withdrawing account!',
                );
        }
        $guildApplication = WebGuildApplication::wherePlayerId($player->id)
            ->whereGuildId($guild->id)
            ->whereStatus(GuildApplicationStatus::OPEN)
            ->first();
        if(!$guildApplication) {
            return redirect(route('community.view.guild.my.applications.index', [Str::strToUrl($guild->name)]))
                ->with(
                    'error',
                    'Guild application does not exists.',
                );
        }

        $application = WebGuildApplication::find($guildApplication->id);
        $application->delete();

        return redirect(route('community.view.guild.my.applications.index', [Str::strToUrl($guild->name)]))
            ->with(
                'success',
                'You withdrew the application.'
            );
    }

    private function canApply(Model $player, Model $guild): array
    {
        $errorMsg = [];
        if(GuildApplications::hasApplied($guild->id, $player->id)
            || GuildApplications::hasAppliedBefore($guild->id, $player->id)) {
            $errorMsg = [
                'success' => false,
                'type' => 'error',
                'title' => 'Error!',
                'message' => 'Character has already applied for this guild in the last 30 days.',
            ];
        }

        if(!$guild->applications_enabled) {
            $errorMsg = [
                'success' => false,
                'type' => 'error',
                'title' => 'Error!',
                'message' => 'Guild is closed for applications!',
            ];
        }

        return $errorMsg;
    }
}
