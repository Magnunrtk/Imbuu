<?php

declare(strict_types=1);

namespace App\Http\Controllers\Character;

use App\Models\AccountBan;
use App\Utils\EasyFormaters;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\FormerName;
use App\Models\Player;
use Carbon\Carbon; 

class SearchCharacterController extends Controller
{
    public function searchView(): View
    {
        return view('community.view.character.index');
    }

    public function search(Request $request): View
    {
        $playerInfo = $request->player;
        $account_id = $playerInfo->account_id;

        $formerName = FormerName::where('player_id', $playerInfo->id)
        ->orderBy('id', 'desc') // Ordenar pelo ID
        ->first();

        if($formerName){
            $currentTime = Carbon::now()->timestamp;
            if ($formerName->time < $currentTime) {
                $formerName->delete();
                $formerName = null;
            }
        }

        $banInfo = AccountBan::where('account_id', $account_id)->first();
        $formaters = new EasyFormaters();

        foreach ($playerInfo->deaths as $death) {

            $mostDamageBy = $death->mostdamage_by;
            $killedBy = $death->killed_by;
        
            if (is_numeric($mostDamageBy)) {

                $player = Player::where('id', $mostDamageBy)->first();
        
                if ($player) {
                    $death->mostdamage_by = $player->name;
                }
            }

            if(is_numeric($killedBy)){
                
                $player = Player::where('id', $killedBy)->first();

                if ($player) {
                    $death->killed_by = $player->name;
                }
            }

        }

        return view('community.view.character.search', compact('playerInfo', 'banInfo', 'formaters', 'formerName'));
    }

    public function searchPost(Request $request): RedirectResponse
    {
        $searchName = (string) $request->input('searchName');

        $formerName = FormerName::where('name', $searchName)
        ->orderBy('id', 'desc') // Ordenar pelo ID
        ->first();

        if($formerName){

            $existingPlayerName = Player::where('id', $formerName->player_id)->first();
            $searchName = $existingPlayerName->name;
        }

        return redirect()->route('community.view.character.search', $searchName);
    }
}
