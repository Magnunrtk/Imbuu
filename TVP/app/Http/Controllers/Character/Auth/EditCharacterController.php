<?php

declare(strict_types=1);

namespace App\Http\Controllers\Character\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\WebAccounts;
use Illuminate\Support\Facades\Auth;
use App\Models\Player;
use Carbon\Carbon;
use App\Models\FormerName;
use Illuminate\Support\Facades\DB;

class EditCharacterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request): View
    {
        $player = $request->player;

        $nameLockExists = DB::table('player_namelocks')->where('player_id', $player->id)->exists();

        return view('account.character.edit.index', compact('player', 'nameLockExists'));
    }

    public function edit(Request $request): RedirectResponse
    {
        $newName = $request->input('new_name');
        $newName = preg_replace("/[^a-zA-Z' ]/", '', $newName);
        $accountId = Auth::user()->id;

        $prohibitedNames = ['staff', 'admin', 'moderator', 'support', 'luan', 'luanzera', 'luanzerah', 'luanzeira', 'luanzeirah', 'luaanzera', 'luanzeraa', 'luanzeraah', 'corrupta', 'corrupção', 'corrupcao'];

        foreach ($prohibitedNames as $prohibitedName) {
            if (stripos($newName, $prohibitedName) !== false) {
                return Redirect::back()->with(
                    'error',
                    'This name violates our naming rules.'
                );
            }
        }

        if (!preg_match('/^[A-Z]/', $newName)) {
            return Redirect::back()->with(
                'error',
                'The name must begin with a capital letter.'
            );
        }

        $uniqueChars = count(array_unique(str_split($newName)));
        if ($uniqueChars < 4) {
            return Redirect::back()->with('error', 'The name must contain at least 4 different characters.');
        }

        if (preg_match_all('/[a-zA-Z]/', $newName) < 5) {
            return Redirect::back()->with(
                'error',
                'The name must have at least 5 letters.'
            );
        }

        if (substr_count($newName, "'") > 1 || substr_count($newName, " ") > 1) {
            return Redirect::back()->with(
                'error',
                'The name can contain only one apostrophe and one space.'
            );
        }

        if (strlen($newName) > 15) {
            return Redirect::back()->with(
                'error',
                'The name must be at most 15 characters long.'
            );
        }

        // Atualizar o nome do personagem
        $player = $request->player;

        $nameLockExists = DB::table('player_namelocks')->where('player_id', $player->id)->exists();

        if($nameLockExists == false){
            
            $webAccount = WebAccounts::where('account_id', $accountId)->where('shop_coins', '>=', 100)->first();
            if (!$webAccount) {
                return Redirect::back()->with(
                    'error',
                    'You do not have enough coins to perform this action.'
                );
            }
        }

        $existingPlayerName = Player::where('name', $newName)->first();
        if ($existingPlayerName) {
            return Redirect::back()->with(
                'error',
                'This name is already taken. Please choose a different name.'
            );
        }

        $existingFormerName = FormerName::where('name', $newName)->first();
        if ($existingFormerName) {
            return Redirect::back()->with(
                'error',
                'This name is already taken in former names. Please choose a different name.'
            );
        }

        $newName = ltrim($newName, " '");

        // Verifica se o jogador está online
        $playerOnline = DB::table('players_online')->where('player_id', $player->id)->first();
        if ($playerOnline) {
            return Redirect::back()->with(
                'error',
                'The name cannot be changed while the player is online.'
            );
        }

        // Encontrar o último registro na tabela former_names para o player_id atual
        $formerName = FormerName::where('player_id', $player->id)
        ->orderBy('id', 'desc') // Ordenar pelo ID
        ->first();

        if($formerName){

            $currentTime = Carbon::now()->timestamp;
            if ($formerName->time > $currentTime) {

                $formattedTime = Carbon::createFromTimestamp($formerName->time)->format('d:M:Y h:i:s');        
                return Redirect::back()->with(
                    'error',
                    "You can change the name after: {$formattedTime} GMT-3."
                );
            }
        }

        if($player->account_id != $accountId){      
            return Redirect::back()->with(
                'error',
                "This character does not belong to this account."
            );
        }

        $webAccount = WebAccounts::where('account_id', $accountId)
            ->where('shop_coins', '>=', 100)
            ->first();

        if($nameLockExists == false){
            
            $webAccount->shop_coins -= 100;
            $webAccount->save();
        }

        $currentTimeSave = Carbon::now()->format('d:M:Y h:i:s');

        $formerNameCount = FormerName::where('player_id', $player->id)->count();
        if(!$formerNameCount){

            $formerNameCount = 1;
            $daysAdd = $formerNameCount * 30;
            $timestampPlus7Days = Carbon::now()->addDays($daysAdd)->timestamp;

            FormerName::create([
                'name' => $player->name,
                'player_id' => $player->id,
                'time' => $timestampPlus7Days,
                'create_at' => $currentTimeSave,
            ]);

        }else{

            // Calcular o novo timestamp
            $daysAdd = $formerNameCount * 30;
            $timestampPlus7Days = Carbon::now()->addDays($daysAdd)->timestamp;

            // Atualizar o registro existente
            FormerName::where('player_id', $player->id)
                ->update([
                    'name' => $player->name,
                    'time' => $timestampPlus7Days,
                    'create_at' => $currentTimeSave,
                ]);
        } 

        if($nameLockExists == true) {
            DB::table('player_namelocks')->where('player_id', $player->id)->delete();
        }

        $player->name = $newName;
        $player->hidden = $request->has('hidden');
        $player->save();

        return redirect()->route('account.index')->with('success', 'The character information has been changed.');
    }
    
}
