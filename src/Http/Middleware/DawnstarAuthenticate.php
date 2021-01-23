<?php

namespace Dawnstar\Http\Middleware;

use Closure;

class DawnstarAuthenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (auth('admin')->check()) {

            app()->setLocale(session("dawnstar.language.code"));

            session(['dawnstar.isPanel' => true]);

            return $next($request);
        }
        return redirect()->route('dawnstar.auth.index');
    }
}
