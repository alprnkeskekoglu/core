<?php

namespace Dawnstar\Core\Repositories;

use Dawnstar\Core\Contracts\TranslationInterface;
use Dawnstar\Core\Models\CategoryTranslation;

class CategoryTranslationRepository implements TranslationInterface
{
    public function store($page)
    {
        $languages = request('languages');
        $translations = request('translations');

        foreach ($translations as $languageId => $translation) {
            $translation['category_id'] = $page->id;
            $translation['language_id'] = $languageId;
            $translation['status'] = $languages[$languageId];
            $translation['slug'] = ($translation['slug'] && $translation['slug'] != '/') ?
                ltrim($translation['slug'], '/') :
                $translation['slug'];

            $translationModel = CategoryTranslation::create($translation);

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
            $translation['slug'] = ($translation['slug'] && $translation['slug'] != '/') ?
                ltrim($translation['slug'], '/') :
                $translation['slug'];
            $translationModel = CategoryTranslation::updateOrCreate(
                [
                    'category_id' => $page->id,
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
