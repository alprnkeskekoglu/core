<?php

namespace Dawnstar\Http\Middleware;

use Innoio\Core\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
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
        dd(Auth::guard('admin')->check());
        if (Auth::guard('admin')->check()) {
            return redirect()->route('dawnstar.dashboard');
        }

        return $next($request);
    }
}
