<?php

namespace Dawnstar\Core\Providers;

use Dawnstar\Core\Repositories\Interfaces\StructureRepositoryInterface;
use Dawnstar\Core\Repositories\Interfaces\UrlRepositoryInterface;
use Dawnstar\Core\Repositories\Interfaces\WebsiteRepositoryInterface;
use Dawnstar\Core\Repositories\StructureRepository;
use Dawnstar\Core\Repositories\UrlRepository;
use Dawnstar\Core\Repositories\WebsiteRepository;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(WebsiteRepositoryInterface::class, WebsiteRepository::class);
        $this->app->bind(StructureRepositoryInterface::class, StructureRepository::class);
        $this->app->bind(UrlRepositoryInterface::class, UrlRepository::class);
    }
}
