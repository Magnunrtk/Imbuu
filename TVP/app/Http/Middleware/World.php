<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;

class World
{
    /**
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return Closure|RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $worldSlug = $request->route('worldSlug');
        $worldKey = array_search($worldSlug, array_column(config('multi_world.worlds'), 'slug'));
        if ($worldKey === false) {
            return redirect()->route('landing');
        }
        $request->world = \App\Utils\World::getCurrentWorld();
        return $next($request);
    }
}
