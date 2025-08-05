<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;

class Player
{
    /**
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return Closure|RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $characterName = str_replace('+', ' ', $request->route('characterName'));
        $player = \App\Models\Player::whereRaw('LOWER(`name`) LIKE ? ',[trim(strtolower($characterName))])->first();
        if (is_null($player)) {
            return redirect()->route('community.view.character.searchView')
                ->with(
                    'error',
                    sprintf('Player with name <b>%s</b> does not exist.', htmlspecialchars($characterName, ENT_QUOTES))
                );
        }
        if (strcmp($characterName, $player->name) !== 0) {
            return redirect()->route(
                'community.view.character.search',
                str_replace(' ', '+', $player->name)
            );
        }
        $request->player = $player;
        return $next($request);
    }
}
