<?php

namespace Dawnstar\Http\Middleware;

use Dawnstar\Models\Website;
use Innoio\Core\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DefaultWebsite
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
        $defaultWebsite = Website::where('status', 1)->where('default', 1)->first();
        if($defaultWebsite) {
            return $next($request);
        }
        return redirect()->route('dawnstar.websites.create');
    }
}
