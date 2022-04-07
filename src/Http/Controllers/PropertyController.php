<?php

namespace Dawnstar\Core\Http\Controllers;

use Dawnstar\Core\Models\Property;
use Dawnstar\Core\Models\Structure;
use Dawnstar\Core\Repositories\PropertyRepository;
use Dawnstar\Core\Repositories\PropertyTranslationRepository;
use Dawnstar\ModuleBuilder\Services\ModuleBuilderService;
use Illuminate\Http\Request;

class PropertyController extends BaseController
{
    private PropertyRepository $propertyRepository;
    private PropertyTranslationRepository $propertyTranslationRepository;

    public function __construct(PropertyRepository $propertyRepository, PropertyTranslationRepository $propertyTranslationRepository)
    {
        $this->propertyRepository = $propertyRepository;
        $this->propertyTranslationRepository = $propertyTranslationRepository;
    }

    public function index(Structure $structure)
    {
        canUser("structure.{$structure->id}.index");

        $moduleBuilder = new ModuleBuilderService($structure, 'property');
        $languages = $moduleBuilder->languages;

        $properties = $this->propertyRepository->getByStructureId($structure)->sortBy('order');

        return view('Core::modules.property.index', compact('structure', 'properties', 'moduleBuilder', 'languages'));
    }

    public function store(Structure $structure)
    {
        canUser("structure.{$structure->id}.create");

        $moduleBuilder = new ModuleBuilderService($structure, 'property');
        $moduleBuilder->validate();

        $property = $this->propertyRepository->store($structure);
        $this->propertyTranslationRepository->store($property);

        return to_route('dawnstar.structures.properties.index', $structure)->with(['success' => __('Core::property.success.store')]);
    }

    public function edit(Structure $structure, Property $property)
    {
        canUser("structure.{$structure->id}.edit");

        $moduleBuilder = new ModuleBuilderService($structure, 'property', $property);
        $languages = $moduleBuilder->languages;
        $activeLanguageIds = $moduleBuilder->getActiveTranslations();

        $properties = $this->propertyRepository->getByStructureId($structure)->sortBy('order');

        return view('Core::modules.property.edit', compact('structure', 'properties', 'property', 'moduleBuilder', 'languages', 'activeLanguageIds'));
    }

    public function update(Structure $structure, Property $property)
    {
        canUser("structure.{$structure->id}.edit");

        $moduleBuilder = new ModuleBuilderService($structure, 'property', $property);
        $moduleBuilder->validate();

        $property = $this->propertyRepository->update($property);
        $this->propertyTranslationRepository->update($property);

        return to_route('dawnstar.structures.properties.index', $structure)->with(['success' => __('Core::property.success.update')]);
    }

    public function destroy(Structure $structure, Property $property)
    {
        canUser("structure.{$structure->id}.destroy");

        $this->propertyRepository->destroy($property);

        return to_route('dawnstar.structures.properties.index', $structure)->with(['success' => __('Core::property.success.destroy')]);
    }

    public function saveOrder(Request $request)
    {
        $orderedData = $request->get('data');

        foreach ($orderedData as $key => $ordered) {
            $item = Property::find($ordered['id']);

            if($item) {
                unset($ordered['id']);
                $item->update(['order' => ++$key]);
            }
        }
    }
}
