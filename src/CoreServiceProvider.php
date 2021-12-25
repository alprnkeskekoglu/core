<?php

namespace Dawnstar\Core;

use Core\Console\Commands\CreateSearchView;
use Core\Console\Commands\Install;
use Core\Console\Commands\Update;
use Core\Foundation\Dawnstar;
use Core\Http\Middleware\Authenticate;
use Core\Http\Middleware\DefaultWebsite;
use Core\Http\Middleware\Maintenance;
use Core\Http\Middleware\RedirectIfAuthenticated;
use Core\Models\CategoryTranslation;
use Core\Models\ContainerTranslation;
use Core\Models\Page;
use Core\Models\PageTranslation;
use Core\Observers\CategoryTranslationObserver;
use Core\Observers\ContainerTranslationObserver;
use Core\Observers\PageObserver;
use Core\Observers\PageTranslationObserver;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Core\Providers\ConfigServiceProvider;
use Core\Providers\RouteServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(ConfigServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);

        $this->app->singleton(Core::class, Core::class);
        $this->app->bind("Dawnstar", Core::class);
    }

    public function boot()
    {
        include_once base_path('vendor/dawnstar/dawnstar/src/Http/helpers.php');

        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');
        $this->loadViewsFrom(__DIR__ . '/Resources/views/panel', 'Core');
        $this->loadViewsFrom(__DIR__ . '/Resources/views/web', 'CoreWeb');
        $this->loadTranslationsFrom(__DIR__ . '/Resources/lang', 'Core');

        $this->publishes([__DIR__ . '/Assets' => public_path('vendor/dawnstar/core/assets')], 'dawnstar-core-assets');


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
