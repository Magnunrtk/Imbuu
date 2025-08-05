<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Utils\GuildRanks;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class GuildRank
{
    /**
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return Closure|RedirectResponse
     */
    public function handle($request, Closure $next, ...$requiredGuildRanks)
    {
        $guild = $request->guild;
        $highestRankInGuild = GuildRanks::getHighestRankLevel($guild);
        if (!in_array($highestRankInGuild, $requiredGuildRanks)) {
            return Redirect::back();
        }
        return $next($request);
    }
}
