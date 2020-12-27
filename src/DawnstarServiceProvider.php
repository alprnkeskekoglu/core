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
        $this->loadViewsFrom(__DIR__ . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR, 'DawnstarView');
        $this->publishes([__DIR__ . DIRECTORY_SEPARATOR . 'Assets' => public_path('vendor/dawnstar/assets')], 'DawnstarPublish');

        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');
    }
}
