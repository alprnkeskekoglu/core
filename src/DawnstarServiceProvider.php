<?php

namespace Dawnstar;

use Dawnstar\Console\Commands\CreateSearchView;
use Dawnstar\Console\Commands\Install;
use Dawnstar\Console\Commands\Update;
use Dawnstar\Foundation\Dawnstar;
use Dawnstar\Http\Middleware\Authenticate;
use Dawnstar\Http\Middleware\DefaultWebsite;
use Dawnstar\Http\Middleware\Maintenance;
use Dawnstar\Http\Middleware\RedirectIfAuthenticated;
use Dawnstar\Models\CategoryTranslation;
use Dawnstar\Models\ContainerTranslation;
use Dawnstar\Models\Page;
use Dawnstar\Models\PageTranslation;
use Dawnstar\Observers\CategoryTranslationObserver;
use Dawnstar\Observers\ContainerTranslationObserver;
use Dawnstar\Observers\PageObserver;
use Dawnstar\Observers\PageTranslationObserver;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Dawnstar\Providers\ConfigServiceProvider;
use Dawnstar\Providers\RouteServiceProvider;

class   DawnstarServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(ConfigServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);

        $this->app->singleton(Dawnstar::class, Dawnstar::class);
        $this->app->bind("Dawnstar", Dawnstar::class);
    }

    public function boot()
    {
        include_once base_path('vendor/dawnstar/dawnstar/src/Http/helpers.php');

        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');
        $this->loadViewsFrom(__DIR__ . '/Resources/views/panel', 'Dawnstar');
        $this->loadViewsFrom(__DIR__ . '/Resources/views/web', 'DawnstarWeb');
        $this->loadTranslationsFrom(__DIR__ . '/Resources/lang', 'Dawnstar');

        $this->publishes([__DIR__ . '/Assets' => public_path('vendor/dawnstar/assets')], 'dawnstar-assets');


        if ($this->app->runningInConsole()) {
            $this->commands([
                Install::class,
                Update::class,
                CreateSearchView::class,
            ]);
        }

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('dawnstar_auth', Authenticate::class);
        $router->aliasMiddleware('dawnstar_guest', RedirectIfAuthenticated::class);
        $router->aliasMiddleware('default_website', DefaultWebsite::class);
        $router->aliasMiddleware('maintenance', Maintenance::class);


        Page::observe(PageObserver::class);
        ContainerTranslation::observe(ContainerTranslationObserver::class);
        PageTranslation::observe(PageTranslationObserver::class);
        CategoryTranslation::observe(CategoryTranslationObserver::class);
    }
}
