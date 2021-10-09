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
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class DawnstarServiceProvider extends ServiceProvider
{


    public function register()
    {
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');
    }
}
