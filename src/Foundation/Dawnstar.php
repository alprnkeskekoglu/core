<?php

namespace Dawnstar\Core\Foundation;

use Dawnstar\Core\Models\Website;
use Dawnstar\Core\Repositories\Interfaces\WebsiteRepositoryInterface;
use Dawnstar\Core\Services\ParseUrlService;

class Dawnstar
{
    protected ?Website $website;

    /**
     * Dawnstar constructor.
     */
    public function __construct(
        protected ParseUrlService $parseUrlService,
        protected WebsiteRepositoryInterface $websiteRepository
    )
    {
        view()->share("dawnstar", $this);
    }

    /**
     * @param $website
     * @return void
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * @return Website|null
     */
    public function website(): ?Website
    {
        $parsedUrl = $this->parseUrlService->getParsedUrl();

        return $this->websiteRepository->getWebsiteByUrl($parsedUrl);
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

    public function setDawnstarSettings(array $settings)
    {
        foreach ($settings as $key => $value) {
            $this->$key = $value;
        }
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
