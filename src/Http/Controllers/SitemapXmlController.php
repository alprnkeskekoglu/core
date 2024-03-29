<?php

namespace Dawnstar\Core\Http\Controllers;

use Dawnstar\Core\Models\Container;
use Dawnstar\Core\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SitemapXmlController extends BaseController
{
    private $perPage = 50;
    private $languageId;
    private $page;

    public function __construct(Request $request)
    {
        $this->languageId = $request->get('lang');
        $this->page = $request->get('page');

    }

    public function index(Request $request)
    {
        if($this->languageId) {
            return $this->getMainUrls($request);
        } else {
            return $this->getLanguageUrls();
        }
    }

    private function getMainUrls(Request $request)
    {
        $website = dawnstar()->website;

        $urlModels = Url::whereHas('model', function ($query) {
            $query->where('status', 1)
                ->where('language_id', $this->languageId)
                ->whereHas('parent', function ($que) {
                    $que->where('status', 1);
                });
        })
            ->where('type', 1);

        $urlsCount = $urlModels->get()->count();


        if(is_null($this->page) && $urlsCount > $this->perPage) {
            $pageCount = ceil($urlsCount / $this->perPage);
            return $this->getSubUrls($pageCount);
        } else {
            $urlModels = $urlModels->skip(($this->page - 1) * $this->perPage)
                ->limit($this->perPage)
                ->get();

            return $this->getUrls($urlModels);
        }
    }

    private function getLanguageUrls()
    {
        $website = dawnstar()->website;

        $urls = [];
        if($website) {
            $languages = $website->languages;

            foreach ($languages as $language) {
                $urls[] = [
                    'url' => route('sitemap_xml') . '?lang=' . $language->id
                ];
            }
        }

        return response()->view('CoreWeb::sitemap_xml.index', compact('urls'))->header("Content-Type", "application/xhtml+xml");;
    }



    private function getUrls($urlModels)
    {
        $urls = [];
        foreach ($urlModels as $urlModel) {

            $alternates = $this->getUrlAlternates($urlModel);
            $urls[] = [
                'url' => url($urlModel->url),
                'alternates' => $alternates,
                'changefreq' => 'daily',
                'priority' => $this->getUrlPriority($urlModel)
            ];
        }

        return response()->view('CoreWeb::sitemap_xml.detail', compact('urls'))->header("Content-Type", "application/xhtml+xml");;
    }

    private function getUrlAlternates($urlModel)
    {
        $alternates = [];

        $parentModel = $urlModel->model->parent;
        $translations = $parentModel->translations()->where('language_id', '<>', $this->languageId)->get();

        foreach ($translations as $translation) {
            $alternates[] = [
                'hreflang' => $translation->language->code,
                'url' => url($translation->url->url)
            ];
        }

        return $alternates;
    }

    private function getUrlPriority($urlModel)
    {
        $parentModel = $urlModel->model->parent;

        if(is_a($parentModel, Container::class)) {
            if($parentModel->key == 'homepage') {
                return '1.0';
            }
            return '0.8';
        }
        return '0.6';
    }

    private function getSubUrls($pageCount)
    {
        $urls = [];
        for($i = 1; $i<=$pageCount; $i++) {
            $urls[] = [
                'url' => route('sitemap_xml') . '?lang=' . $this->languageId . '&amp;page=' . $i
            ];
        }

        return response()->view('CoreWeb::sitemap_xml.index', compact('urls'))->header("Content-Type", "application/xhtml+xml");;
    }
}
