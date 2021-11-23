<?php

namespace Dawnstar\Repositories;

use Dawnstar\Contracts\TranslationInterface;
use Dawnstar\Models\Page;
use Dawnstar\Models\PageTranslation;

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
            $translation['slug'] = $translation['slug'] != '/' ? ltrim($translation['slug'], '/') : $translation['slug'];
            PageTranslation::create($translation);
        }
    }

    public function update($page)
    {
        $languages = request('languages');
        $translations = request('translations');

        foreach ($translations as $languageId => $translation) {
            $translation['slug'] = $translation['slug'] != '/' ? ltrim($translation['slug'], '/') : $translation['slug'];
            PageTranslation::updateOrCreate(
                [
                    'page_id' => $page->id,
                    'language_id' => $languageId,
                    'status' => $languages[$languageId],
                ],
                $translation
            );
        }
    }
}
