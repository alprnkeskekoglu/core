<?php

namespace Dawnstar\Core;

use Dawnstar\Core\Console\Commands\CreateSearchView;
use Dawnstar\Core\Console\Commands\Install;
use Dawnstar\Core\Console\Commands\Update;
use Dawnstar\Core\Foundation\Dawnstar;
use Dawnstar\Core\Http\Middleware\Authenticate;
use Dawnstar\Core\Http\Middleware\DefaultWebsite;
use Dawnstar\Core\Http\Middleware\Maintenance;
use Dawnstar\Core\Http\Middleware\RedirectIfAuthenticated;
use Dawnstar\Core\Models\CategoryTranslation;
use Dawnstar\Core\Models\ContainerTranslation;
use Dawnstar\Core\Models\Page;
use Dawnstar\Core\Models\PageTranslation;
use Dawnstar\Core\Observers\CategoryTranslationObserver;
use Dawnstar\Core\Observers\ContainerTranslationObserver;
use Dawnstar\Core\Observers\PageObserver;
use Dawnstar\Core\Observers\PageTranslationObserver;
use Dawnstar\Core\Providers\RepositoryServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Dawnstar\Core\Providers\ConfigServiceProvider;
use Dawnstar\Core\Providers\RouteServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(ConfigServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);

        $this->app->singleton(Dawnstar::class, Dawnstar::class);
        $this->app->bind("Dawnstar", Dawnstar::class);
    }

    public function boot()
    {
        include_once base_path('vendor/dawnstar/core/src/Http/helpers.php');

        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');
        $this->loadViewsFrom(__DIR__ . '/Resources/views/panel', 'Core');
        $this->loadViewsFrom(__DIR__ . '/Resources/views/web', 'CoreWeb');
        $this->loadTranslationsFrom(__DIR__ . '/Resources/lang', 'Core');

        $this->publishes([__DIR__ . '/Assets' => public_path('vendor/dawnstar/core')], 'dawnstar-core-assets');


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
