<?php

namespace Dawnstar\Core\Repositories;

use Dawnstar\Core\Contracts\TranslationInterface;
use Dawnstar\Core\Models\Container;
use Dawnstar\Core\Models\ContainerTranslation;
use Illuminate\Support\Facades\Schema;

class ContainerTranslationRepository implements TranslationInterface
{

    public function store($container)
    {
        $languages = request('languages', []);
        $translations = request('translations', []);

        foreach ($translations as $languageId => $translation) {
            $translation['container_id'] = $container->id;
            $translation['language_id'] = $languageId;
            $translation['status'] = $languages[$languageId];

            if($container->structure->has_url == false) {
                $translation['slug'] = null;
            } elseif(isset($translation['slug'])) {
                $translation['slug'] = ($translation['slug'] && $translation['slug'] != '/') ?
                    ltrim($translation['slug'], '/') :
                    $translation['slug'];
            }

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
        $languages = request('languages', []);
        $translations = request('translations', []);

        foreach ($translations as $languageId => $translation) {

            if(isset($translation['slug'])) {
                $translation['slug'] = ($translation['slug'] && $translation['slug'] != '/') ?
                    ltrim($translation['slug'], '/') :
                    $translation['slug'];
            }

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
