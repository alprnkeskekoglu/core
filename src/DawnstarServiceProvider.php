<?php

namespace Dawnstar;

use Dawnstar\Console\Commands\Update;
use Dawnstar\Http\Middleware\Authenticate;
use Dawnstar\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Dawnstar\Providers\ConfigServiceProvider;
use Dawnstar\Providers\RouteServiceProvider;

class DawnstarServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(ConfigServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }

    public function boot()
    {
        include_once base_path('vendor/dawnstar/dawnstar/src/Http/helpers.php');

        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');
        $this->loadViewsFrom(__DIR__ . '/Resources/views/panel', 'Dawnstar');
        $this->loadTranslationsFrom(__DIR__ . '/Resources/lang', 'Dawnstar');

        $this->publishes([__DIR__ . '/Assets' => public_path('vendor/dawnstar/assets')], 'dawnstar-assets');


        if ($this->app->runningInConsole()) {
            $this->commands([
                Update::class,
            ]);
        }

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('dawnstar_auth', Authenticate::class);
        $router->aliasMiddleware('dawnstar_guest', RedirectIfAuthenticated::class);
    }
}
