<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Http\Requests\StructureRequest;
use Dawnstar\Models\Container;
use Dawnstar\Models\ContainerTranslation;
use Dawnstar\Models\ModuleBuilder;
use Dawnstar\Models\Structure;
use Dawnstar\Region\Models\Country;
use Dawnstar\Repositories\ContainerRepository;
use Dawnstar\Repositories\ContainerTranslationRepository;
use Dawnstar\Repositories\ModuleBuilderRepository;
use Dawnstar\Repositories\StructureRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModuleBuilderController extends BaseController
{
    protected ModuleBuilderRepository $moduleBuilderRepository;

    public function __construct(ModuleBuilderRepository $moduleBuilderRepository)
    {
        $this->moduleBuilderRepository = $moduleBuilderRepository;
    }

    public function index()
    {
        canUser("structure.{$moduleBuilder->structure->id}.index");

        $moduleBuilders = $this->moduleBuilderRepository->getAll();
        return view('Dawnstar::modules.module_builder.index', compact('moduleBuilders'));
    }

    public function edit(ModuleBuilder $moduleBuilder)
    {
        canUser("structure.{$moduleBuilder->structure->id}.edit");

        return view('Dawnstar::modules.module_builder.edit', compact('moduleBuilder'));
    }

    public function update(ModuleBuilder $moduleBuilder, Request $request)
    {
        canUser("structure.{$moduleBuilder->structure->id}.edit");

        $data = $request->get('data');
        $metaTags = $request->get('meta_tags');

        $moduleBuilder->update([
            'data' => $data,
            'meta_tags' => $metaTags
        ]);

        return response()->json(['success' => __('Dawnstar::module_builder.success.update')]);
    }

    public function getBuilderData(ModuleBuilder $moduleBuilder)
    {
        canUser("structure.{$moduleBuilder->structure->id}.edit");

        return response()->json(['builderData' => $moduleBuilder->data, 'metaTags' => $moduleBuilder->meta_tags]);
    }

    public function getTranslations()
    {
        $return = [
            'back' => __('Dawnstar::general.back'),
            'save' => __('Dawnstar::general.save'),
            'add_new' => __('Dawnstar::general.add_new'),
            'yes' => __('Dawnstar::general.yes'),
            'no' => __('Dawnstar::general.no'),
            'required' => __('Dawnstar::general.required'),
            'translation' => __('Dawnstar::module_builder.translation'),
            'type' => __('Dawnstar::module_builder.type'),
            'name' => __('Dawnstar::module_builder.name'),
            'col' => __('Dawnstar::module_builder.col'),
            'label' => __('Dawnstar::module_builder.label'),
            'max_count' => __('Dawnstar::module_builder.max_count'),
            'selectable' => __('Dawnstar::module_builder.selectable'),
            'rules' => __('Dawnstar::module_builder.rules'),
            'options' => __('Dawnstar::module_builder.options'),
            'queries' => __('Dawnstar::module_builder.queries'),
        ];

        return response()->json(['translations' => $return]);
    }
}
