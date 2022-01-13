<?php

namespace Dawnstar\Core\Observers;

use Dawnstar\Core\Models\CategoryTranslation;

class CategoryTranslationObserver
{
    public function created(CategoryTranslation $categoryTranslation)
    {
        if($categoryTranslation->status != 1 || is_null($categoryTranslation->slug)) {
            return;
        }
        $urlText = $this->getUrlText($categoryTranslation);

        $categoryTranslation->url()->create(
            [
                'website_id' => $categoryTranslation->category->structure->website_id,
                'url' => $urlText
            ]
        );
    }

    public function updated(CategoryTranslation $categoryTranslation)
    {
        if($categoryTranslation->status != 1 || is_null($categoryTranslation->slug)) {
            return;
        }

        if(is_null($categoryTranslation->url)) {
            $this->created($categoryTranslation);
        }

        $urlText = $this->getUrlText($categoryTranslation);

        $categoryTranslation->url->update(['url' => $urlText]);
    }

    private function getUrlText(CategoryTranslation $categoryTranslation): string
    {
        $language = $categoryTranslation->language;
        $website = session('dawnstar.website');
        $containerTranslation = $categoryTranslation->parent->container->translations()->where('language_id', $language->id)->first();

        if($website->url_language_code != 1 && $website->defaultLanguage()->id == $language->id) {
            $urlText = '/';
        } else {
            $urlText = "/{$language->code}/";
        }
        $urlText .= $containerTranslation->slug . '/' . $categoryTranslation->slug;


        return $urlText;
    }
}
