<?php

namespace Dawnstar\Core\Repositories;

use Dawnstar\Core\Contracts\TranslationInterface;
use Dawnstar\Core\Models\PropertyOptionTranslation;
use Dawnstar\Core\Models\PropertyTranslation;

class PropertyOptionTranslationRepository implements TranslationInterface
{
    public function store($propertyOption)
    {
        $languages = request('languages');
        $translations = request('translations');

        foreach ($translations as $languageId => $translation) {
            $translation['property_option_id'] = $propertyOption->id;
            $translation['language_id'] = $languageId;
            $translation['status'] = $languages[$languageId];

            if(isset($translation['slug'])) {
                $translation['slug'] = ($translation['slug'] && $translation['slug'] != '/') ?
                    ltrim($translation['slug'], '/') :
                    $translation['slug'];
            }

            PropertyOptionTranslation::create($translation);
        }
    }

    public function update($propertyOption)
    {
        $languages = request('languages');
        $translations = request('translations');

        foreach ($translations as $languageId => $translation) {

            if(isset($translation['slug'])) {
                $translation['slug'] = ($translation['slug'] && $translation['slug'] != '/') ?
                    ltrim($translation['slug'], '/') :
                    $translation['slug'];
            }

            PropertyOptionTranslation::updateOrCreate(
                [
                    'property_option_id' => $propertyOption->id,
                    'language_id' => $languageId,
                    'status' => $languages[$languageId],
                ],
                $translation
            );
        }
    }
}
