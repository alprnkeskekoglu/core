<?php

namespace Dawnstar\Core\Http\Middleware;

use Dawnstar\Core\Models\Website;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, ['admin']);

        config(['auth.defaults.guard' => 'admin']);

        if(is_null(session('dawnstar'))) {
            setSession();
        }

        app()->setLocale(session('dawnstar.language.code', 'tr'));

        return $next($request);
    }

    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('dawnstar.login');
        }
    }
}
