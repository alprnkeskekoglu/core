<?php

namespace Dawnstar\Core\Foundation;

use Dawnstar\Core\Models\Website;
use Dawnstar\Core\Repositories\WebsiteRepository;
use Dawnstar\Core\Services\MetaService;

/**
 * Class Dawnstar
 * @package Dawnstar\Core\Foundation
 */
class Dawnstar
{
    /**
     * Dawnstar constructor.
     */
    public function __construct
    (
        protected WebsiteRepository $websiteRepository,
    )
    {
        view()->share("dawnstar", $this);
    }

    public function website(): Website
    {
        return $this->websiteRepository->getByUrl();
    }

    public function metasHtml()
    {
        $meta = new MetaService();

        return $meta->getHtml();
    }

    /**
     * @return string
     */
    public function homepageUrl()
    {
        $homepage = \Dawnstar\Core\Models\Structure::where('key', 'homepage')->first();

        if ($homepage && $homepage->container->translation) {
            return $homepage->container->translation->url;
        }
        return "javascript:void(0);";
    }

    /**
     * @return mixed
     */
    public function language()
    {
        $request = request();
        if ($request->segment(1)) {
            $language = $this->website->languages()->where('code', $request->segment(1))->first();
            if ($language) {
                return $language;
            }
        }

        return $this->website->languages()->whereIn('code', browserLanguageCodes())->first();
    }

    /**
     * @param bool $removeActiveLanguage
     * @return array
     */
    public function otherLanguages(bool $removeActiveLanguage = false)
    {
        $parent = $this->parent;

        if (is_null($parent)) {
            return [];
        }

        $translations = $parent->translations()->where('status', 1)->get();
        $activeLanguage = $this->language;

        $return = [];
        foreach ($translations as $translation) {
            if ($removeActiveLanguage && $activeLanguage->id == $translation->language_id) {
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
            return $this->$name();
        }

        return null;
    }
}
