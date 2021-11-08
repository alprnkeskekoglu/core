<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Http\Requests\StructureRequest;
use Dawnstar\Models\Container;
use Dawnstar\Models\ContainerTranslation;
use Dawnstar\Models\Structure;

class StructureController extends BaseController
{
    public function index()
    {
        $structures = Structure::all();
        return view('Dawnstar::modules.structure.index', compact('structures'));
    }

    public function create()
    {
        $languages = session('dawnstar.languages');
        $hasHomepage = Structure::where('key', 'homepage')->exists();
        $hasSearch = Structure::where('key', 'search')->exists();

        return view('Dawnstar::modules.structure.create', compact('languages', 'hasHomepage', 'hasSearch'));
    }

    public function store(StructureRequest $request)
    {
        $data = $request->only(['status', 'type', 'key', 'has_detail', 'has_category', 'has_property', 'has_url', 'is_searchable']);
        $languages = $request->get('languages');
        $translations = $request->get('translations');

        $data['website_id'] = session('dawnstar.website.id');

        $structure = Structure::create($data);
        $container = Container::create(['structure_id' => $structure->id]);
        foreach ($translations as $languageId => $translation) {
            $translation['container_id'] = $container->id;
            $translation['language_id'] = $languageId;
            $translation['status'] = $languages[$languageId];
            ContainerTranslation::create($translation);
        }

        return redirect()->route('dawnstar.structures.index')->with(['success' => __('Dawnstar::structure.success.store')]);
    }


    public function edit(Structure $structure)
    {
        $languages = session('dawnstar.languages');

        return view('Dawnstar::modules.structure.edit', compact('structure', 'languages'));
    }

    public function update(Structure $structure, StructureRequest $request)
    {
        $data = $request->only(['status', 'type', 'key', 'has_detail', 'has_category', 'has_property', 'has_url', 'is_searchable']);
        $languages = $request->get('languages');
        $translations = $request->get('translations');

        $structure->update($data);

        foreach ($translations as $languageId => $translation) {
            ContainerTranslation::updateOrCreate(
                [
                    'container_id' => $structure->container->id,
                    'language_id' => $languageId,
                    'status' => $languages[$languageId],
                ],
                $translation
            );
        }

        return redirect()->route('dawnstar.structures.index')->with(['success' => __('Dawnstar::structure.success.update')]);
    }

    public function destroy(Structure $structure)
    {
        $structure->delete();

        return redirect()->route('dawnstar.structures.index')->with(['success' => __('Dawnstar::structure.success.destroy')]);
    }
}
