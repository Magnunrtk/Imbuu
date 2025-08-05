<?php

declare(strict_types=1);

namespace App\Http\Controllers\Character\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCharacterRequest;
use App\Models\Player;
use App\Utils\FormatText;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\FormerName;

class CreateCharacterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        return view('account.character.create.index');
    }

    public function create(CreateCharacterRequest $request): RedirectResponse
    {

        $user = Auth::user();
        $accountId = $user->id;

        $bazaarCount = DB::table('myaac_charbazaar')
            ->where('account_old', $accountId)
            ->count();

        $playerCount = DB::table('players')
            ->where('account_id', $accountId)
            ->count();
    
        $totalCount = $bazaarCount + $playerCount;
        
        if($totalCount >= 6){

            return Redirect::back()->with('error', 'You cannot create more than 6 characters.');
        }

        $characterName = $request->input('name');
        $checkCharacterName = FormatText::checkTextFormat($characterName, 'name');

        $prohibitedNames = ['staff', 'admin', 'moderator', 'support', 'luan', 'luanzera', 'luanzerah', 'luanzeira', 'luanzeirah', 'luaanzera', 'luanzeraa', 'luanzeraah', 'corrupta', 'corrupção', 'corrupcao'];

        foreach ($prohibitedNames as $prohibitedName) {
            if (stripos($characterName, $prohibitedName) !== false) {
                return Redirect::back()->with(
                    'error',
                    'This name violates our naming rules.'
                );
            }
        }

        if (!empty($checkCharacterName)) {
            return Redirect::back()->with('error', $checkCharacterName);
        }

        $existingFormerName = FormerName::where('name', $characterName)->first();
        if($existingFormerName) {
            return Redirect::back()->with(
                'error',
                'This name is already taken in former names. Please choose a different name.'
            );
        }

        Player::create($request->all());
        return redirect(route('account.index'))
            ->with(
                'success',
                sprintf(
                    'The character <b>%s</b> has been created.<br><br>See you in %s!',
                    $characterName,
                    config('server.serverName')
                ),
            );
    }
}
