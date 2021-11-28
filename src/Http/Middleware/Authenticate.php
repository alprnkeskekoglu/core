<?php

namespace Dawnstar\Http\Middleware;

use Dawnstar\Models\Website;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, ['admin']);

        config(['auth.defaults.guard' => 'admin']);

        $admin = auth('admin')->user();
        $website = Website::where('status', 1)->where('default', 1)->first();
        $languages = $website->languages;
        $language = $website->languages()->wherePivot('default', 1)->first();

        session([
            'dawnstar' => [
                'admin' => $admin,
                'website' => $website,
                'languages' => $languages,
                'language' => $language,
            ]
        ]);

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
