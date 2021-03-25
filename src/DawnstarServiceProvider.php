<?php

namespace Dawnstar;

use Dawnstar\Console\Commands\CreateAdmin;
use Dawnstar\Console\Commands\CreateSearchView;
use Dawnstar\Console\Commands\InstallDawnstar;
use Dawnstar\Console\Commands\UpdateDawnstar;
use Dawnstar\Foundation\Dawnstar;
use Dawnstar\Http\Middleware\DawnstarAuthenticate;
use Dawnstar\Http\Middleware\DawnstarRedirectIfAuthenticated;
use Dawnstar\Models\CategoryDetail;
use Dawnstar\Models\Container;
use Dawnstar\Models\ContainerDetail;
use Dawnstar\Models\PageDetail;
use Dawnstar\Observers\CategoryDetailObserver;
use Dawnstar\Observers\ContainerDetailObserver;
use Dawnstar\Observers\ContainerObserver;
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


        $this->app->singleton(Dawnstar::class, Dawnstar::class);
        $this->app->bind("Dawnstar", Dawnstar::class);
    }

    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/Resources/lang', 'DawnstarLang');
        $this->loadViewsFrom(__DIR__ . '/Resources/views/panel', 'DawnstarView');
        $this->loadViewsFrom(__DIR__ . '/Resources/views/web', 'DawnstarWebView');

        $this->publishes([__DIR__ . '/Assets' => public_path('vendor/dawnstar/assets')], 'dawnstar-assets');

        $this->publishes([__DIR__ . '/Publishes' => base_path()], 'dawnstar-publishes');

        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallDawnstar::class,
                UpdateDawnstar::class,
                CreateSearchView::class,
                CreateAdmin::class,
            ]);
        }

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('dawnstar.auth', DawnstarAuthenticate::class);
        $router->aliasMiddleware('dawnstar.guest', DawnstarRedirectIfAuthenticated::class);


        Container::observe(ContainerObserver::class);
        ContainerDetail::observe(ContainerDetailObserver::class);
        PageDetail::observe(PageDetailObserver::class);
        CategoryDetail::observe(CategoryDetailObserver::class);
    }
}
