<?php

namespace Dawnstar\Core\Foundation;

use Dawnstar\Core\Models\Website;

class Dawnstar
{
    /**
     * Dawnstar constructor.
     */
    public function __construct()
    {
        view()->share("dawnstar", $this);
    }

    /**
     * @return mixed
     */
    public function website()
    {
        $fullUrl = request()->fullUrl();
        $parsedUrl = parse_url($fullUrl);

        $domain = $parsedUrl["host"] = str_replace("www.", "", $parsedUrl["host"]);
        $domainArray = [$domain, "www." . $domain];

        return Website::whereIn('domain', $domainArray)->first();
    }

    /**
     * @return string
     */
    public function metasHtml()
    {
        $meta = new Meta();

        return $meta->getHtml();
    }

    public function homepageUrl()
    {
        $homepage = \Dawnstar\Core\Models\Structure::where('key', 'homepage')->first();

        if ($homepage && $homepage->container->translation) {
            return $homepage->container->translation->url;
        }
        return "javascript:void(0);";
    }


    public function otherLanguages(bool $removeActiveLanguage = false)
    {
        $parent = $this->parent;

        $translations = $parent->translations;
        $activeLanguage = $this->language;

        $return = [];
        foreach ($translations as $translation) {
            if (($removeActiveLanguage && $activeLanguage->id == $translation->language_id) || $translation->url) {
                continue;
            }
            $return[] = [
                'id' => $translation->language_id,
                'code' => $translation->language->code,
                'url' => url($translation->url->url),
                'active' => $activeLanguage->id == $translation->language_id
            ];
        }
        return $return;
    }

    /**
     * @param $name
     * @return null
     */
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
