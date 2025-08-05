<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Utils\EasyFormaters;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Models\DeleteCharacter;
use Illuminate\Support\Facades\Auth;
use App\Models\WebAccounts;

class DeleteCharacterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request): View
    { 
        $formaters = new EasyFormaters();
        $name = $request->input('characterName');

        if($name == null && session('name') == null){

            return view('account.overview.index');
        }

        $characterId = $request->input('characterId');  // Certifique-se de passar o ID do personagem
        
        return view('account.character.delete.index', [
            'formaters' => $formaters,
            'name' => $name,
            'characterId' => $characterId, // Passe o ID do personagem para a view
        ]);
    }

    public function action(Request $request, $id): RedirectResponse
    {
        
        $name = $id;
        $accountId = Auth::id();
        $characterId = $request->input('characterId'); 

        $recoveryValidation = WebAccounts::where('account_id', $accountId)
            ->where('confirmed', 0)
            ->first();

        return redirect()->route('account.delete.index')->with([
            'error' => 'Your account has not been confirmed.',
            'name' => $name,
            'characterId' => $characterId,
        ]);

        $character = DeleteCharacter::where('name', $name)
                                    ->where('account_id', $accountId)
                                    ->first();


        $recoveryKey = $request->input('recovery_key');
        $recoveryValidation = WebAccounts::where('account_id', $accountId)
                                ->where('recovery_key', $recoveryKey)
                                ->first();

        if(!$recoveryValidation){

            return Redirect::back()->with(['error' => 'Invalid recovery key.', 'name' => $name]);
        }

        if(!$character){

            return Redirect::back()->with(['error' => 'Character not found.', 'name' => $name]);
        }
        
        // Se o personagem existe e pertence ao usuário autenticado, exclua-o
        if($character) {
            $character->delete();
            return redirect()->route('account.index')->with([
                'success' => 'Personagem excluído com sucesso.',
            ]);
        }
    }
}
