<?php

namespace Dawnstar\Core\Observers;

use Dawnstar\Core\Models\PageTranslation;

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
        $containerTranslation = $pageTranslation->parent->container->translations()->where('language_id', $language->id)->first();

        if($website->url_language_code != 1 && $website->defaultLanguage()->id == $language->id) {
            $urlText = '/';
        } else {
            $urlText = "/{$language->code}/";
        }
        $urlText .= $containerTranslation->slug . '/' . $pageTranslation->slug;

        return rtrim($urlText, '/');
    }
}
