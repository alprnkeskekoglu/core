<?php

namespace Dawnstar\Foundation;

use Dawnstar\Models\Container;
use Illuminate\Support\Facades\Artisan;

class ContainerFileKit
{
    protected Container $container;
    protected int $websiteId;
    protected string $containerType;
    protected string $key;
    protected bool $hasCategory;
    protected bool $hasDetail;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->websiteId = $container->website_id;
        $this->containerType = $container->type;
        $this->key = $container->key;
        $this->hasDetail = $container->has_detail == 1;
        $this->hasCategory = $container->has_category == 1;
    }

    public function createFiles()
    {
        $this->createController();
        $this->createBlades();
    }

    //region CreateController
    private function createController()
    {
        Artisan::call('make:controller Website' . $this->websiteId . '/' . ucfirst($this->key) . 'Controller');

        //TODO: write functions
    }
    //endregion

    //region CreateBlades
    private function createBlades()
    {
        if($this->containerType == 'static') {
            $this->createContainerBlade();
        } else {
            if($this->hasDetail) {
                $this->createContainerBlade();
            }

            $this->createPageBlade();

            if($this->hasCategory) {
                $this->createCategoryBlade();
            }
        }
    }

    private function createContainerBlade()
    {
        if($this->containerType == 'dynamic') {
            $defaultView = "container_dynamic.container";
            if($this->hasCategory) {
                $defaultView = "container_dynamic_category.container";
            }
        } else {
            $defaultView = "container_static.container";
        }

        $viewFolder = resource_path('views/pages/' . strtolower($this->key));
        $view = $viewFolder . "/container.blade.php";

        if (!file_exists($viewFolder)) {
            $oldmask = umask(0);
            mkdir($viewFolder, 0777, true);
            umask($oldmask);
        }

        if (!file_exists($view)) {
            $replaced = "@extends('web.layouts.app')\n\n@section('content')\n\t@include('DawnstarWebView::default." . $defaultView . "')\n@endsection";
            file_put_contents($view, $replaced);
        }
    }

    private function createPageBlade()
    {
        if ($this->hasCategory) {
            $defaultView = "container_dynamic_category.page";
        } else {
            $defaultView = "container_dynamic.page";
        }

        $viewFolder = resource_path('views/pages/' . strtolower($this->key));
        $view = $view_folder . "/page.blade.php";

        if (!file_exists($viewFolder)) {
            $oldmask = umask(0);
            mkdir($viewFolder, 0777, true);
            umask($oldmask);
        }

        if (!file_exists($view)) {
            $replaced = "@extends('web.layouts.app')\n\n@section('content')\n\t@include('DawnstarWebView::default." . $defaultView . "')\n@endsection";
            file_put_contents($view, $replaced);
        }
    }

    private function createCategoryBlade()
    {
        //TODO: check
        if ($this->hasCategory) {
            $default_view = "container_dynamic_category.page";
        } else {
            $default_view = "container_dynamic.page";
        }

        $viewFolder = resource_path('views/pages/' . strtolower($this->key));
        $view = $view_folder . "/page.blade.php";

        if (!file_exists($viewFolder)) {
            $oldmask = umask(0);
            mkdir($viewFolder, 0777, true);
            umask($oldmask);
        }

        if (!file_exists($view)) {
            $replaced = "@extends('web.layouts.app')\n\n@section('content')\n\t@include('DawnstarWebView::default." . $default_view . "')\n@endsection";
            file_put_contents($view, $replaced);
        }
    }
    //endregion
}
