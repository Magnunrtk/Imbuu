<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;

class Admin
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return Closure|RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (!is_null(\Auth::user()) && \Auth::user()->checkRole('admin')) {
            return $next($request);
        }
        return redirect('/');
    }
}
