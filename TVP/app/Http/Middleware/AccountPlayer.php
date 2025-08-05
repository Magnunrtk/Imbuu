<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AccountPlayer
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
            return redirect()->route('account.index',)
                ->with(
                    'error',
                    'Character does not exists.'
                );
        }
        if($player->account_id !== Auth::user()->id) {
            return redirect()->route('account.index',)
                ->with(
                    'error',
                    'This character does not belong to your account.'
                );
        }
        if (strcmp($characterName, $player->name) !== 0) {
            return redirect()->route(
                'account.character.edit.index',
                str_replace(' ', '+', $player->name)
            );
        }
        $request->player = $player;
        return $next($request);
    }
}
