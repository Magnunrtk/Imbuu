<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;

class Guild
{
    /**
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return Closure|RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $guildName = str_replace('+', ' ', $request->route('guildName'));
        $guild = \App\Models\Guild::whereRaw('LOWER(`name`) LIKE ? ',[trim(strtolower($guildName))])->first();
        if (is_null($guild)) {
            return redirect()->route('community.guilds.index')
                ->with(
                    'error',
                    'Guild was not found.'
                );
        }
        if (strcmp($guildName, $guild->name) !== 0) {
            return redirect()->route(
                'community.view.guild.index',
                str_replace(' ', '+', $guild->name)
            );
        }
        $request->guild = $guild;
        return $next($request);
    }
}
