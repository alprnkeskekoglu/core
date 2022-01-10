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
        $translations = request('translations');

        foreach ($translations as $languageId => $translation) {
            $translation['page_id'] = $page->id;
            $translation['language_id'] = $languageId;
            $translation['status'] = $languages[$languageId];

            if(isset($translation['slug'])) {
                $translation['slug'] = ($translation['slug'] && $translation['slug'] != '/') ?
                    ltrim($translation['slug'], '/') :
                    $translation['slug'];
            }

            $translationModel = PageTranslation::create($translation);

            if (isset($translation['medias'])) {
                $this->getMediaRepository()->syncMedias($translationModel, $translation['medias']);
                unset($translation['medias']);
            }

            $this->getExtrasRepository()->store($translationModel, $translation);

            if (request('meta_tags')) {
                $this->getMetaTagRepository()->sync($translationModel, request('meta_tags'));
            }
        }
    }

    public function update($page)
    {
        $languages = request('languages');
        $translations = request('translations');

        foreach ($translations as $languageId => $translation) {

            if(isset($translation['slug'])) {
                $translation['slug'] = ($translation['slug'] && $translation['slug'] != '/') ?
                    ltrim($translation['slug'], '/') :
                    $translation['slug'];
            }

            $translationModel = PageTranslation::updateOrCreate(
                [
                    'page_id' => $page->id,
                    'language_id' => $languageId,
                    'status' => $languages[$languageId],
                ],
                $translation
            );

            if (isset($translation['medias'])) {
                $this->getMediaRepository()->syncMedias($translationModel, $translation['medias']);
                unset($translation['medias']);
            }

            $this->getExtrasRepository()->store($translationModel, $translation);

            if (request('meta_tags')) {
                $this->getMetaTagRepository()->sync($translationModel, request('meta_tags'));
            }
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
