<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Models\CategoryDetail;
use Dawnstar\Models\Container;
use Dawnstar\Models\ContainerDetail;
use Dawnstar\Models\Language;
use Dawnstar\Models\PageDetail;
use Dawnstar\Models\Url;
use Dawnstar\Models\Website;
use Dawnstar\Tracker\Foundation\Tracker;
use Illuminate\Http\Request;

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

        $dawnstar->website = $website;

        if(!isset($parsedUrl['path'])) {
            $homePage = Container::where('website_id', $website->id)->where('key', 'homepage')->first();
            $homePageDetail = $homePage->details()->where('language_id', $website->defaultLanguage()->id)->first();

            if($homePageDetail) {
                return redirect()->to($homePageDetail->url->url);
            }
            abort(404);
        }

        $path = $parsedUrl['path'];
        $url = Url::where('url', $path)->where('website_id', $website->id)->first();

        if(is_null($url)) {
            abort(404);
        }

        $detail = $url->model;
        $parent = $detail->parent;

        $dawnstar->url = $url;
        $dawnstar->language = Language::find($detail->language_id);
        $dawnstar->relation = $detail;
        $dawnstar->parent = $parent;

        # Passive and Draft Models
        if($detail->status == 3 || $parent->status == 3 || ($parent->status == 2 && $request->get('preview') != 1)) {
            abort(404);
        }

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

        $tracker = new Tracker();
        $tracker->init();

        return $function;
    }
}
