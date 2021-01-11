<?php

namespace Dawnstar;

use Dawnstar\Console\Commands\InstallDawnstar;
use Dawnstar\Http\Middleware\DawnstarAuthenticate;
use Dawnstar\Http\Middleware\DawnstarRedirectIfAuthenticated;
use Dawnstar\Models\CategoryDetail;
use Dawnstar\Models\ContainerDetail;
use Dawnstar\Models\PageDetail;
use Dawnstar\Observers\CategoryDetailObserver;
use Dawnstar\Observers\ContainerDetailObserver;
use Dawnstar\Observers\PageDetailObserver;
use Illuminate\Routing\Router;
use Dawnstar\Console\Kernel;
use Dawnstar\Providers\ConfigServiceProvider;
use Dawnstar\Providers\RouteServiceProvider;
use Dawnstar\Providers\SeedServiceProvider;
use Illuminate\Support\ServiceProvider;

class DawnstarServiceProvider extends ServiceProvider
{


    public function register()
    {
        $this->app->register(SeedServiceProvider::class);
        $this->app->register(ConfigServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }

    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/Resources/lang', 'DawnstarLang');
        $this->loadViewsFrom(__DIR__ . '/Resources/views/panel', 'DawnstarView');
        $this->loadViewsFrom(__DIR__ . '/Resources/views/web', 'DawnstarWebView');
        $this->publishes([__DIR__ . '/Assets' => public_path('vendor/dawnstar/assets')], 'DawnstarPublish');


        $this->publishes([__DIR__ . '/Publishes' => resource_path('lang')]);

        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallDawnstar::class
            ]);
        }

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('dawnstar.auth', DawnstarAuthenticate::class);
        $router->aliasMiddleware('dawnstar.guest', DawnstarRedirectIfAuthenticated::class);


        ContainerDetail::observe(ContainerDetailObserver::class);
        PageDetail::observe(PageDetailObserver::class);
        CategoryDetail::observe(CategoryDetailObserver::class);
    }
}
