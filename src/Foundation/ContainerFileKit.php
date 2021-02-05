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
        $this->createFormBuilders();
    }

    #region CreateController
    private function createController()
    {
        $folder = app_path('Http/Controllers/Website' . $this->websiteId);
        if (!file_exists($folder)) {
            $oldmask = umask(0);
            mkdir($folder, 0777, true);
            umask($oldmask);
        }

        $content = $this->getControllerContent();

        Artisan::call('make:controller Website' . $this->websiteId . '/' . ucfirst($this->key) . 'Controller');


        file_put_contents($folder . '/' . ucfirst($this->key) . 'Controller.php', $content);
    }

    private function getControllerContent()
    {
        $defaultContent = file_get_contents(__DIR__ . '/../DefaultFiles/Controller.template');

        $replaceKeys = [
            '{&namespace&}', '{&class&}', '{%containerPage%}', '{%detailPage%}', '{%categoryPage%}'
        ];

        $replaceValues = [
            "App\Http\Controllers\Website{$this->websiteId}",
            ucfirst($this->key) . "Controller",
        ];


        $replaceValues[] = $this->getContainerPageFunction();
        if ($this->containerType != 'static') {
            $replaceValues[] = $this->getDetailPageFunction();
            if ($this->hasCategory) {
                $replaceValues[] = $this->getCategoryPageFunction();
            } else {
                $replaceValues[] = '';
            }
        } else {
            $replaceValues[] = '';
            $replaceValues[] = '';
        }

        return str_replace($replaceKeys, $replaceValues, $defaultContent);
    }

    private function getContainerPageFunction()
    {
        $content = 'public function containerPage(Dawnstar $dawnstar) {';

        if($this->key == 'search') {
            $content .= "\n\t\t$search = new Dawnstar\Foundation\Search();";
            $content .= "\n\t\t$results = $search->getResults();";
            $content .= "\n\t\treturn view('pages." . strtolower($this->key) . ".container', compact('results'));";
        } else {
            $content .= "\n\t\treturn view('pages." . strtolower($this->key) . ".container');";
        }

        $content .= "\n\t}\n";

        return $content;
    }

    private function getDetailPageFunction()
    {
        $content = 'public function detailPage(Dawnstar $dawnstar) {';
        $content .= "\n\t\treturn view('pages." . strtolower($this->key) . ".page');";
        $content .= "\n\t}\n";

        return $content;
    }

    private function getCategoryPageFunction()
    {
        $content = 'public function categoryPage(Dawnstar $dawnstar) {';
        $content .= "\n\t\treturn view('pages." . strtolower($this->key) . ".category');";
        $content .= "\n\t}\n";

        return $content;
    }
    #endregion

    #region CreateBlades
    private function createBlades()
    {
        if ($this->containerType == 'static') {
            $this->createContainerBlade();
        } else {
            if ($this->hasDetail) {
                $this->createContainerBlade();
            }

            $this->createPageBlade();

            if ($this->hasCategory) {
                $this->createCategoryBlade();
            }
        }
    }

    private function createContainerBlade()
    {
        if ($this->containerType == 'dynamic') {
            $defaultView = "container_dynamic.container";
            if ($this->hasCategory) {
                $defaultView = "container_dynamic_category.container";
            }
        } elseif($this->key == 'homepage') {
            $defaultView = "homepage";
        } elseif($this->key == 'search') {
            $defaultView = "search";
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
            $replaced = "@extends('layouts.app')\n\n@section('content')\n\t@include('DawnstarWebView::default_blades." . $defaultView . "')\n@endsection";
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
        $view = $viewFolder . "/page.blade.php";

        if (!file_exists($viewFolder)) {
            $oldmask = umask(0);
            mkdir($viewFolder, 0777, true);
            umask($oldmask);
        }

        if (!file_exists($view)) {
            $replaced = "@extends('layouts.app')\n\n@section('content')\n\t@include('DawnstarWebView::default_blades." . $defaultView . "')\n@endsection";
            file_put_contents($view, $replaced);
        }
    }

    private function createCategoryBlade()
    {
        $defaultView = "container_dynamic_category.category";

        $viewFolder = resource_path('views/pages/' . strtolower($this->key));
        $view = $viewFolder . "/category.blade.php";

        if (!file_exists($viewFolder)) {
            $oldmask = umask(0);
            mkdir($viewFolder, 0777, true);
            umask($oldmask);
        }

        if (!file_exists($view)) {
            $replaced = "@extends('layouts.app')\n\n@section('content')\n\t@include('DawnstarWebView::default_blades." . $defaultView . "')\n@endsection";
            file_put_contents($view, $replaced);
        }
    }
    #endregion

    #region createFormBuilders
    private function createFormBuilders()
    {
        $types[] = 'container';
        if ($this->containerType != 'static') {
            $types[] = 'page';

            if ($this->hasCategory) {
                $types[] = 'category';
            }
        }

        $formBuilderFolder = resource_path('views/vendor/dawnstar/form_builder/' . strtolower($this->key));

        if (!file_exists($formBuilderFolder)) {
            $oldmask = umask(0);
            mkdir($formBuilderFolder, 0777, true);
            umask($oldmask);
        }

        foreach ($types as $type) {

            $formBuilderFile = $formBuilderFolder . '/' . $type . '.php';

            if (!file_exists($formBuilderFile)) {
                $content = file_get_contents(__DIR__ . '/../DefaultFiles/form_builders/' . $type . '.php');
                file_put_contents($formBuilderFile, $content);
            }
        }

    }
    #endregion
}
