<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StreamerAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('streamer_id')) {
            return redirect()->route('account.manage.streamer.login')->withErrors(['auth_error' => 'You must log in first.']);
        }

        return $next($request);
    }
}
