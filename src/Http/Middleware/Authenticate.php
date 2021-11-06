<?php

namespace Dawnstar\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, ['admin']);
        config(['auth.defaults.guard' => 'admin']);
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
