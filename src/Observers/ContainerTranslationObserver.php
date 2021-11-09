<?php

namespace Dawnstar\Observers;

use Dawnstar\Models\CategoryTranslation;
use Dawnstar\Models\ContainerTranslation;
use Dawnstar\Models\PageTranslation;

class ContainerTranslationObserver
{
    public function created(ContainerTranslation $containerTranslation)
    {
        $urlText = $this->getUrlText($containerTranslation);

        $containerTranslation->url()->create(
            [
                'website_id' => $containerTranslation->container->structure->website_id,
                'url' => $urlText
            ]
        );
    }

    public function updated(ContainerTranslation $containerTranslation)
    {
        if(is_null($containerTranslation->url)) {
            $this->created($containerTranslation);
        }
        
        $urlText = $this->getUrlText($containerTranslation);

        $url = $containerTranslation->url->update(['url' => $urlText]);
    }

    private function getUrlText(ContainerTranslation $containerTranslation): string
    {
        $language = $containerTranslation->language;
        $website = session('dawnstar.website');
        $urlText = ($website->url_language_code == 1 ? "/{$language->code}/" : '/') . $containerTranslation->slug;

        return rtrim($urlText, '/');
    }
}
