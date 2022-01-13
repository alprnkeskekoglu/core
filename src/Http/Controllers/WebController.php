<?php

namespace Dawnstar\Core\Http\Controllers;

use Dawnstar\Core\Models\CategoryTranslation;
use Dawnstar\Core\Models\Container;
use Dawnstar\Core\Models\ContainerTranslation;
use Dawnstar\Core\Models\Language;
use Dawnstar\Core\Models\PageTranslation;
use Dawnstar\Core\Models\Structure;
use Dawnstar\Core\Models\Url;
use Dawnstar\Core\Models\Website;
use Dawnstar\Tracker\Foundation\Tracker;
use Illuminate\Support\Facades\Hash;

class WebController extends BaseController
{
    public function index()
    {
        $dawnstar = dawnstar();

        $fullUrl = request()->fullUrl();
        $parsedUrl = parse_url($fullUrl);

        $dawnstar->website = $website = $this->getWebsite($parsedUrl);

        if(!isset($parsedUrl['path'])) {
            $homePage = Structure::where('website_id', $website->id)->where('key', 'homepage')->first();
            $homePageDetail = $homePage->container->translations()->where('language_id', $website->defaultLanguage()->id)->first();

            if(is_null($homePageDetail)) {
                abort(404);
            }

            if($homePageDetail->url->url != '/') {
                return redirect()->to($homePageDetail->url->url);
            } else {
                $parsedUrl['path'] = '/';
            }
        }

        $path = $parsedUrl['path'];
        $url = Url::where('url', $path)->where('website_id', $website->id)->first();

        if(is_null($url) || is_null($url->model)) {
            abort(404);
        }

        $translation = $url->model;
        $parent = $translation->parent;

        $dawnstar->url = $url;
        $dawnstar->parent = $translation->parent;
        $dawnstar->translation = $translation;
        $dawnstar->language = $translation->language;
        $dawnstar->parent = $parent;

        # Passive and Draft Models
        if($translation->status === 0 || $parent->status === 0 || ($parent->status == 2 && request('preview') != 1)) {
            abort(404);
        }

        $structure = $parent->structure;
        $dawnstar->container = $structure->container;
        $function = null;

        $controllerClass = 'App\Http\Controllers\Website' . $website->id . '\\' . ucfirst($structure->key) . 'Controller';
        $controller = new $controllerClass();

        if(is_a($translation, ContainerTranslation::class)) {

            $function = $controller->container($dawnstar);

        } elseif(is_a($translation, PageTranslation::class)) {

            $function = $controller->page($dawnstar);

        } elseif(is_a($translation, CategoryTranslation::class)) {

            $function = $controller->category($dawnstar);
        }

        if(is_null($function)) {
            abort(404);
        }

        $tracker = new Tracker();
        $tracker->init();

        return $function;
    }

    private function getWebsite(array $parsedUrl)
    {
        $domain = $parsedUrl["host"] = str_replace("www.", "", $parsedUrl["host"]);
        $domainArray = [$domain, "www." . $domain];

        return Website::whereIn('domain', $domainArray)->firstOrFail();
    }
}
