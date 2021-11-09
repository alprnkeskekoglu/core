<?php

namespace Dawnstar\Repositories;

use Dawnstar\Contracts\ContainerTranslationInterface;
use Dawnstar\Models\Container;
use Dawnstar\Models\ContainerTranslation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;

class ContainerTranslationRepository implements ContainerTranslationInterface
{

    public function getById(int $id): Container
    {
        return ContainerTranslation::find($id);
    }

    public function store(Container $container, FormRequest $containerTranslationRequest)
    {
        $languages = $containerTranslationRequest->get('languages');
        $translations = $containerTranslationRequest->get('translations');

        foreach ($translations as $languageId => $translation) {
            $translation['container_id'] = $container->id;
            $translation['language_id'] = $languageId;
            $translation['status'] = $languages[$languageId];
            $translation['slug'] = $translation['slug'] != '/' ? ltrim($translation['slug'], '/') : $translation['slug'];
            ContainerTranslation::create($translation);
        }
    }

    public function update(Container $container, FormRequest $containerTranslationRequest)
    {
        $languages = $containerTranslationRequest->get('languages');
        $translations = $containerTranslationRequest->get('translations');

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

    public function destroy(Container $container)
    {
        // TODO: Implement destroy() method.
    }
}
