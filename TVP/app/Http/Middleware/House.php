<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;

class House
{
    /**
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return Closure|RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (filter_var($request->route('houseId'), FILTER_VALIDATE_INT) === false) {
            return redirect()->route('community.houses.index');
        }
        $house = \App\Models\House::find($request->route('houseId'));
        if (is_null($house)) {
            return redirect()->route('community.houses.index')
                ->with(
                    'error',
                    'House was not found.'
                );
        }
        $request->house = $house;
        return $next($request);
    }
}
