<?php

namespace Dawnstar\Core\Repositories;

use Dawnstar\Core\Contracts\TranslationInterface;
use Dawnstar\Core\Models\Page;
use Dawnstar\Core\Models\PageTranslation;

class PageTranslationRepository implements TranslationInterface
{
    public function store($page)
    {
        $languages = request('languages');
        $translations = request('translations', []);

        foreach ($translations as $languageId => $translation) {

            if(isset($translation['slug'])) {
                $translation['slug'] = trimSlug($translation['slug']);
            }
            $translation['status'] = $languages[$languageId];

            $translationModel = PageTranslation::firstOrCreate(
                [
                    'page_id' => $page->id,
                    'language_id' => $languageId,
                ],
                $translation
            );

            if (isset($translation['medias'])) {
                $this->getMediaRepository()->syncMedias($translationModel, $translation['medias']);
                unset($translation['medias']);
            }

            $this->getExtrasRepository()->store($translationModel, $translation);
        }

        if (request('meta_tags')) {
            $this->getMetaTagRepository()->sync($page, request('meta_tags'));
        }
    }

    public function update($page)
    {
        $languages = request('languages');
        $translations = request('translations', []);

        foreach ($translations as $languageId => $translation) {

            if(isset($translation['slug'])) {
                $translation['slug'] = trimSlug($translation['slug']);
            }

            $translation['status'] = $languages[$languageId];
            $translationModel = PageTranslation::updateOrCreate(
                [
                    'page_id' => $page->id,
                    'language_id' => $languageId,
                ],
                $translation
            );

            if (isset($translation['medias'])) {
                $this->getMediaRepository()->syncMedias($translationModel, $translation['medias']);
                unset($translation['medias']);
            }

            $this->getExtrasRepository()->store($translationModel, $translation);
        }

        if (request('meta_tags')) {
            $this->getMetaTagRepository()->sync($page, request('meta_tags'));
        }
    }

    private function getExtrasRepository()
    {
        return new ExtrasRepository();
    }

    private function getMediaRepository()
    {
        return new MediaRepository();
    }

    private function getMetaTagRepository()
    {
        return new MetaTagRepository();
    }
}
