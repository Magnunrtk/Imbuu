<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Artisan;
use Closure;
use Illuminate\Http\Request;

class ClearViewCache
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return Closure
     */
    public function handle(Request $request, Closure $next)
    {
        if (env('APP_DEBUG') || env('APP_ENV') === 'local') {
            Artisan::call('view:clear');
        }
        return $next($request);
    }
}
