<?php

namespace Dawnstar\Core\Observers;

use Dawnstar\Core\Models\ContainerTranslation;

class ContainerTranslationObserver
{
    public function created(ContainerTranslation $containerTranslation)
    {
        if($containerTranslation->status != 1 || is_null($containerTranslation->slug)) {
            return;
        }
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
        if($containerTranslation->status != 1 || is_null($containerTranslation->slug)) {
            return;
        }

        if(is_null($containerTranslation->url)) {
            $this->created($containerTranslation);
        }

        $urlText = $this->getUrlText($containerTranslation);

        $containerTranslation->url->update(['url' => $urlText]);
    }

    private function getUrlText(ContainerTranslation $containerTranslation): string
    {
        $language = $containerTranslation->language;
        $website = session('dawnstar.website');

        if($website->url_language_code != 1 && $website->defaultLanguage()->id == $language->id) {
            $urlText = '/';
        } else {
            $urlText = "/{$language->code}/";
        }

        $urlText .= $containerTranslation->slug;

        return $urlText;
    }
}
