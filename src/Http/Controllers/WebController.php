<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Models\CategoryDetail;
use Dawnstar\Models\ContainerDetail;
use Dawnstar\Models\Language;
use Dawnstar\Models\PageDetail;
use Dawnstar\Models\Url;
use Dawnstar\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class WebController extends BaseController
{
    public function index(Request $request)
    {
        $dawnstar = dawnstar();

        $fullUrl = $request->fullUrl();
        $parsedUrl = parse_url($fullUrl);

        $domain = $parsedUrl["host"] = str_replace("www.", "", $parsedUrl["host"]);
        $domainArray = [$domain, "www.".$domain];

        $website = Website::whereIn('slug', $domainArray)->first();

        if(is_null($website)) {
            abort(404);
        }

        $url = Url::where('url', $parsedUrl['path'])->where('website_id', $website->id)->first();

        if(is_null($url)) {
            abort(404);
        }

        $detail = $url->model;

        $dawnstar->website = $website;
        $dawnstar->url = $url;
        $dawnstar->language = Language::find($detail->language_id);
        $dawnstar->relation = $detail;

        $function = null;

        if(is_a($detail, ContainerDetail::class)) {
            $container = $detail->container;

            $dawnstar->container = $container;

            $controllerClass = 'App\Http\Controllers\Website' . $website->id . '\\' . ucfirst($container->key) . 'Controller';
            $controller = new $controllerClass();

            $function = $controller->containerPage($dawnstar);
        } elseif(is_a($detail, PageDetail::class)) {

            $container = $detail->page->container;

            $dawnstar->container = $container;

            $controllerClass = 'App\Http\Controllers\Website' . $website->id . '\\' . ucfirst($container->key) . 'Controller';
            $controller = new $controllerClass();
            $function = $controller->detailPage($dawnstar);
        } elseif(is_a($detail, CategoryDetail::class)) {

            $container = $detail->category->container;

            $dawnstar->container = $container;

            $controllerClass = 'App\Http\Controllers\Website' . $website->id . '\\' . ucfirst($container->key) . 'Controller';
            $controller = new $controllerClass();
            $function = $controller->categoryPage($dawnstar);
        }


        if(is_null($function)) {
            abort(404);
        }


        return $function;
    }
}
