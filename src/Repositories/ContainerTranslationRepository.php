<?php

namespace Dawnstar\Repositories;

use Dawnstar\Contracts\TranslationInterface;
use Dawnstar\Models\Container;
use Dawnstar\Models\ContainerTranslation;
use Illuminate\Support\Facades\Schema;

class ContainerTranslationRepository implements TranslationInterface
{

    public function store($container)
    {
        $languages = request('languages');
        $translations = request('translations');

        foreach ($translations as $languageId => $translation) {
            $translation['container_id'] = $container->id;
            $translation['language_id'] = $languageId;
            $translation['status'] = $languages[$languageId];
            $translation['slug'] = ($translation['slug'] && $translation['slug'] != '/') ?
                ltrim($translation['slug'], '/') :
                $translation['slug'];

            $translationModel = ContainerTranslation::create($translation);

            if (isset($translation['medias'])) {
                $this->getMediaRepository()->syncMedias($translationModel, $translation['medias']);
                unset($translation['medias']);
            }

            $this->getExtrasRepository()->store($translationModel, $translation);
        }
    }

    public function update($container)
    {
        $languages = request('languages');
        $translations = request('translations');

        foreach ($translations as $languageId => $translation) {

            $translation['slug'] = ($translation['slug'] && $translation['slug'] != '/') ?
                ltrim($translation['slug'], '/') :
                $translation['slug'];
            $translationModel = ContainerTranslation::updateOrCreate(
                [
                    'container_id' => $container->id,
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
