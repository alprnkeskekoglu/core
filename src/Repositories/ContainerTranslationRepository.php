<?php

namespace Dawnstar\Repositories;

use Dawnstar\Contracts\TranslationInterface;
use Dawnstar\Models\Container;
use Dawnstar\Models\ContainerTranslation;

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
            $translation['slug'] = $translation['slug'] != '/' ? ltrim($translation['slug'], '/') : $translation['slug'];
            ContainerTranslation::create($translation);
        }
    }

    public function update($container)
    {
        $languages = request('languages');
        $translations = request('translations');

        foreach ($translations as $languageId => $translation) {
            $translation['slug'] = $translation['slug'] != '/' ? ltrim($translation['slug'], '/') : $translation['slug'];
            ContainerTranslation::updateOrCreate(
                [
                    'container_id' => $container->id,
                    'language_id' => $languageId,
                    'status' => $languages[$languageId],
                ],
                $translation
            );
        }
    }
}
