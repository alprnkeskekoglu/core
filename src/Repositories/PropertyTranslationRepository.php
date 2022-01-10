<?php

namespace Dawnstar\Core\Repositories;

use Dawnstar\Core\Contracts\TranslationInterface;
use Dawnstar\Core\Models\PropertyTranslation;

class PropertyTranslationRepository implements TranslationInterface
{
    public function store($property)
    {
        $languages = request('languages');
        $translations = request('translations');

        foreach ($translations as $languageId => $translation) {
            $translation['property_id'] = $property->id;
            $translation['language_id'] = $languageId;
            $translation['status'] = $languages[$languageId];

            if(isset($translation['slug'])) {
                $translation['slug'] = ($translation['slug'] && $translation['slug'] != '/') ?
                    ltrim($translation['slug'], '/') :
                    $translation['slug'];
            }

            $translationModel = PropertyTranslation::create($translation);
        }
    }

    public function update($property)
    {
        $languages = request('languages');
        $translations = request('translations');

        foreach ($translations as $languageId => $translation) {

            if(isset($translation['slug'])) {
                $translation['slug'] = ($translation['slug'] && $translation['slug'] != '/') ?
                    ltrim($translation['slug'], '/') :
                    $translation['slug'];
            }

            PropertyTranslation::updateOrCreate(
                [
                    'property_id' => $property->id,
                    'language_id' => $languageId,
                    'status' => $languages[$languageId],
                ],
                $translation
            );
        }
    }
}
