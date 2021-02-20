<?php

namespace Dawnstar\Foundation;

use Dawnstar\Models\CategoryDetail;
use Dawnstar\Models\Container;
use Dawnstar\Models\ContainerDetail;
use Dawnstar\Models\Language;
use Dawnstar\Models\PageDetail;
use Dawnstar\Models\Url;
use Dawnstar\Models\Website;

/**
 * Class Dawnstar
 * @package Dawnstar\Foundation
 * @property Website website
 * @property Url url
 * @property Language language
 * @property ContainerDetail|PageDetail|CategoryDetail relation
 * @property Container container
 * @property array data
 */
class Dawnstar
{
    public $data = [];

    public function __construct()
    {
        view()->share("dawnstar", $this);
    }

    public function website()
    {
        $fullUrl = request()->fullUrl();
        $parsedUrl = parse_url($fullUrl);

        $domain = $parsedUrl["host"] = str_replace("www.", "", $parsedUrl["host"]);
        $domainArray = [$domain, "www.".$domain];

        return Website::whereIn('slug', $domainArray)->first();
    }

    public function defaultLanguage()
    {
        $this->website->defaultLanguage();
    }

    public function homePageUrl()
    {
        $container = Container::where('key', 'homepage')->first();

        if($container) {
            return $container->detail->url;
        }
        return '/';
    }

    public function otherLanguages(bool $removeActiveLanguage = false)
    {
        $parent = $this->relation->parent;

        $details = $parent->details;
        $activeLanguage = $this->language;

        $return = [];
        foreach ($details as $detail) {
            if($removeActiveLanguage && $activeLanguage->id == $detail->language_id) {
                continue;
            }
            $return[] = [
                'language_id' => $detail->language_id,
                'language_code' => $detail->language->code,
                'url' => url($detail->url->url)
            ];
        }
        return $return;
    }

    public function metas()
    {
        return $this->url->metas;
    }

    public function metasHtml()
    {
        $metaFound = new Meta();

        return $metaFound->getHtml();
    }


    public function __get($name)
    {
        if (isset($this->$name)) {
            return $this->$name;
        }
        if (method_exists(self::class, $name)) {
            $this->$name = $this->$name();
        }

        if (isset($this->$name)) {
            return $this->$name;
        }
        return null;
    }
}
