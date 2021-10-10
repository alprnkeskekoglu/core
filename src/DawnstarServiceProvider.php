<?php

namespace Dawnstar;

use Dawnstar\Providers\RouteServiceProvider;
use Illuminate\Support\ServiceProvider;

class   DawnstarServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    public function boot()
    {
        include_once base_path('vendor/dawnstar/dawnstar/src/Http/helpers.php');

        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');
        $this->loadViewsFrom(__DIR__ . '/Resources/views/panel', 'Dawnstar');
        $this->loadTranslationsFrom(__DIR__ . '/Resources/lang', 'Dawnstar');

        $this->publishes([__DIR__ . '/Assets' => public_path('vendor/dawnstar/assets')], 'dawnstar-assets');
    }
}
