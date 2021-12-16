<?php

namespace Dawnstar\Observers;

use Dawnstar\Models\PageTranslation;

class PageTranslationObserver
{
    public function created(PageTranslation $pageTranslation)
    {
        if($pageTranslation->status != 1 || is_null($pageTranslation->slug)) {
            return;
        }
        $urlText = $this->getUrlText($pageTranslation);

        $pageTranslation->url()->create(
            [
                'website_id' => $pageTranslation->page->container->structure->website_id,
                'url' => $urlText
            ]
        );
    }

    public function updated(PageTranslation $pageTranslation)
    {
        if($pageTranslation->status != 1 || is_null($pageTranslation->slug)) {
            return;
        }

        if(is_null($pageTranslation->url)) {
            $this->created($pageTranslation);
        }

        $urlText = $this->getUrlText($pageTranslation);

        $pageTranslation->url->update(['url' => $urlText]);
    }

    private function getUrlText(PageTranslation $pageTranslation): string
    {
        $language = $pageTranslation->language;
        $website = session('dawnstar.website');
        $urlText = ($website->url_language_code == 1 ? "/{$language->code}/" : '/') . $pageTranslation->slug;

        return rtrim($urlText, '/');
    }
}
