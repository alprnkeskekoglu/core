<?php

namespace Dawnstar;

use Dawnstar\Console\Kernel;
use Dawnstar\Providers\RouteServiceProvider;
use Dawnstar\Providers\SeedServiceProvider;
use Illuminate\Support\ServiceProvider;

class DawnstarServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(SeedServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }

    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__. '/Resources/lang', 'DawnstarLang');
        $this->loadViewsFrom(__DIR__. '/Resources/views', 'DawnstarView');

        $this->publishes([__DIR__ . '/Assets' => public_path('vendor/dawnstar/assets')], 'DawnstarPublish');
        $this->publishes([__DIR__ . '/Publishes' => resource_path('lang')]);

        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');
    }
}
