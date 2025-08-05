<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\PlayersOnline;
use App\Utils\World;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Response;

class PlayersOnlineController extends Controller
{
    public function selectWorld(): View|RedirectResponse
    {
        if (!config('multi_world.enabled')) {
            return redirect(route('community.players-online.index'));
        }
        return view('community.players-online.select-world');
    }

    public function index(Request $request, string $worldSlug, string $sorting = 'name'): View
    {
        $world = $request->world;
        
        $playersOnline = PlayersOnline::whereWorldId($world['id'])
        ->whereNotIn('player_id', [1, 36, 37, 4792])
        ->with('player:id,name,level,vocation')
        ->get();

        $playersOnline = match ($sorting) {
            'level' => $playersOnline->sortBy('player.level', SORT_REGULAR, true),
            'vocation' => $playersOnline->sortBy('player.vocation', SORT_REGULAR, true),
            default => $playersOnline->sortBy('player.name', SORT_REGULAR, false),
        };
        return view('community.players-online.list', compact('playersOnline', 'world'));
    }

    public function indexNoWorld(Request $request, string $sorting = 'name'): View
    {
        $playersOnline = PlayersOnline::whereNotIn('player_id', [1, 36, 37, 4792])
        ->with('player:id,name,level,vocation')
        ->get();

        $playersOnline = match ($sorting) {
            'level' => $playersOnline->sortBy('player.level', SORT_REGULAR, true),
            'vocation' => $playersOnline->sortBy('player.vocation', SORT_REGULAR, true),
            default => $playersOnline->sortBy('player.name', SORT_REGULAR, false),
        };
        return view('community.players-online.list', compact('playersOnline'));
    }

    public function selectWorldAction(Request $request): RedirectResponse
    {
        return redirect(route('community.players-online.index', $request->input('world')));
    }

    public function playersOnlineEmac(Request $request)
    {

        if (!$request->hasHeader('x-emac-secret') || $request->header('x-emac-secret') !== 'd92fdc8e-26e9-4e66-ac7e-8a3c6b348d1f') {

            return Response::json(['error' => 'Unauthorized access.'], 403);
        }

        $playersOnline = PlayersOnline::whereNotIn('player_id', [1, 36, 37, 4792])
        ->with('player:id,name,level,vocation')
        ->get();
        
        //$playersOnline = PlayersOnline::with('player:id,name,level,vocation')->get();
        $numberPlayers = $playersOnline->count();

        $response = Response::json([
            //'playersOnline' => $playersOnline,
            'online' => $numberPlayers,
        ]);

        return $response;
    }
}
