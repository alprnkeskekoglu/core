<?php

namespace Dawnstar\Core\Http\Middleware;

use Dawnstar\Core\Models\Website;
use Innoio\Core\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Maintenance
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if(env('DAWNSTAR_MAINTENANCE', false) == true) {
            abort(503);
        }
        return $next($request);
    }
}
