<?php

namespace Dawnstar\Core\Http\Controllers;

use Dawnstar\Core\Foundation\Dawnstar;
use Dawnstar\Core\Models\CategoryTranslation;
use Dawnstar\Core\Models\Container;
use Dawnstar\Core\Models\ContainerTranslation;
use Dawnstar\Core\Models\Language;
use Dawnstar\Core\Models\PageTranslation;
use Dawnstar\Core\Models\Structure;
use Dawnstar\Core\Models\Url;
use Dawnstar\Core\Models\Website;
use Dawnstar\Core\Repositories\WebsiteRepository;
use Dawnstar\Tracker\Foundation\Tracker;
use Illuminate\Support\Facades\Hash;

class WebController extends BaseController
{
    public function __construct
    (
        protected WebsiteRepository $websiteRepository,
        protected Tracker $tracker
    )
    {
    }

    public function index()
    {
        $dawnstar = dawnstar();

        $fullUrl = request()->fullUrl();
        $parsedUrl = parse_url($fullUrl);

        $dawnstar->website = $website = $this->websiteRepository->getByUrl();

        if (!isset($parsedUrl['path'])) {
            $homePage = Structure::where('website_id', $website->id)->where('key', 'homepage')->first();
            $homePageDetail = $homePage->container->translations()->where('language_id', $website->defaultLanguage()->id)->first();

            if (is_null($homePageDetail)) {
                abort(404);
            }

            if ($homePageDetail->url->url != '/') {
                return redirect()->to($homePageDetail->url->url);
            } else {
                $parsedUrl['path'] = '/';
            }
        }

        $path = $parsedUrl['path'];
        $url = Url::where('url', $path)->where('website_id', $website->id)->first();

        if (is_null($url) || is_null($url->model)) {
            abort(404);
        }

        $translation = $url->model;
        $parent = $translation->parent;

        $dawnstar->url = $url;
        $dawnstar->translation = $translation;
        $dawnstar->parent = $translation->parent;
        $dawnstar->language = $translation->language;
        $dawnstar->parent = $parent;

        # Passive and Draft Models
        if ($translation->status === 0 || $parent->status === 0 || ($parent->status == 2 && request('preview') != 1)) {
            abort(404);
        }

        $dawnstar->container = $parent->structure->container;

        $function = $this->getControllerFunction($dawnstar);

        if (is_null($function)) {
            abort(404);
        }

        $this->tracker->init();

        return $function;
    }

    private function getControllerFunction(Dawnstar $dawnstar)
    {
        $function = null;

        $controllerClass = 'App\Http\Controllers\Website' . $dawnstar->website->id . '\\' . ucfirst($dawnstar->parent->structure->key) . 'Controller';
        $controller = new $controllerClass();

        if (is_a($dawnstar->translation, ContainerTranslation::class)) {
            $function = $controller->container($dawnstar);
        } elseif (is_a($dawnstar->translation, PageTranslation::class)) {
            $function = $controller->page($dawnstar);
        } elseif (is_a($dawnstar->translation, CategoryTranslation::class)) {
            $function = $controller->category($dawnstar);
        }

        return $function;
    }
}
