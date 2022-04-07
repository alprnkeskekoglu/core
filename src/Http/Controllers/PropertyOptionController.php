<?php

namespace Dawnstar\Core\Http\Controllers;

use Dawnstar\Core\Models\Property;
use Dawnstar\Core\Models\PropertyOption;
use Dawnstar\Core\Models\Structure;
use Dawnstar\Core\Repositories\PropertyOptionRepository;
use Dawnstar\Core\Repositories\PropertyOptionTranslationRepository;
use Dawnstar\ModuleBuilder\Services\ModuleBuilderService;
use Illuminate\Http\Request;

class PropertyOptionController extends BaseController
{
    private PropertyOptionRepository $propertyOptionRepository;
    private PropertyOptionTranslationRepository $propertyOptionTranslationRepository;

    public function __construct(PropertyOptionRepository $propertyOptionRepository, PropertyOptionTranslationRepository $propertyOptionTranslationRepository)
    {
        $this->propertyOptionRepository = $propertyOptionRepository;
        $this->propertyOptionTranslationRepository = $propertyOptionTranslationRepository;
    }

    public function index(Structure $structure, Property $property)
    {
        canUser("structure.{$structure->id}.index");

        $moduleBuilder = new ModuleBuilderService($structure, 'property');
        $languages = $moduleBuilder->languages;

        $propertyOptions = $this->propertyOptionRepository->getByProperty($property)->sortBy('order');

        return view('Core::modules.property_option.index', compact('structure', 'property', 'propertyOptions', 'moduleBuilder', 'languages'));
    }

    public function store(Structure $structure, Property $property)
    {
        canUser("structure.{$structure->id}.create");

        $moduleBuilder = new ModuleBuilderService($structure, 'property');
        $moduleBuilder->validate();

        $propertyOption = $this->propertyOptionRepository->store($structure, $property);
        $this->propertyOptionTranslationRepository->store($propertyOption);

        return to_route('dawnstar.structures.properties.options.index', [$structure, $property])->with(['success' => __('Core::property.success.store')]);
    }

    public function edit(Structure $structure, Property $property, PropertyOption $option)
    {
        canUser("structure.{$structure->id}.edit");

        $moduleBuilder = new ModuleBuilderService($structure, 'property', $option);
        $languages = $moduleBuilder->languages;
        $activeLanguageIds = $moduleBuilder->getActiveTranslations();

        $propertyOptions = $this->propertyOptionRepository->getByProperty($property)->sortBy('order');

        return view('Core::modules.property_option.edit', compact('structure', 'property', 'propertyOptions', 'option', 'moduleBuilder', 'languages', 'activeLanguageIds'));
    }

    public function update(Structure $structure, Property $property, PropertyOption $option)
    {
        canUser("structure.{$structure->id}.edit");

        $moduleBuilder = new ModuleBuilderService($structure, 'property', $option);
        $moduleBuilder->validate();

        $option = $this->propertyOptionRepository->update($option);
        $this->propertyOptionTranslationRepository->update($option);

        return to_route('dawnstar.structures.properties.options.index', [$structure, $property])->with(['success' => __('Core::property.success.update')]);
    }

    public function destroy(Structure $structure, Property $property, PropertyOption $option)
    {
        canUser("structure.{$structure->id}.destroy");

        $this->propertyOptionRepository->destroy($option);

        return to_route('dawnstar.structures.properties.options.index', [$structure, $property])->with(['success' => __('Core::property.success.destroy')]);
    }

    public function saveOrder(Request $request)
    {
        $orderedData = $request->get('data');

        foreach ($orderedData as $key => $ordered) {
            $item = PropertyOption::find($ordered['id']);

            if($item) {
                unset($ordered['id']);
                $item->update(['order' => ++$key]);
            }
        }
    }
}
