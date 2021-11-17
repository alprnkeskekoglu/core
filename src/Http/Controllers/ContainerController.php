<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Http\Requests\ContainerRequest;
use Dawnstar\Http\Requests\StructureRequest;
use Dawnstar\Models\Container;
use Dawnstar\Models\ContainerTranslation;
use Dawnstar\Models\Structure;
use Dawnstar\Repositories\ContainerRepository;
use Dawnstar\Repositories\ContainerTranslationRepository;
use Dawnstar\Repositories\ModuleBuilderRepository;
use Dawnstar\Repositories\StructureRepository;
use Dawnstar\Services\ModelService;
use Dawnstar\Services\ModuleBuilderService;
use Illuminate\Support\Facades\DB;

class ContainerController extends BaseController
{
    protected ContainerRepository $containerRepository;
    protected ContainerTranslationRepository $containerTranslationRepository;

    public function __construct(ContainerRepository $containerRepository, ContainerTranslationRepository $containerTranslationRepository)
    {
        $this->containerRepository = $containerRepository;
        $this->containerTranslationRepository = $containerTranslationRepository;
    }

    public function edit(Structure $structure, Container $container)
    {
        $moduleBuilder = new ModuleBuilderService($structure, 'container', $container);
        $languages = $moduleBuilder->languages;

        return view('Dawnstar::modules.container.edit', compact('structure', 'container', 'moduleBuilder', 'languages'));
    }

    public function update(Structure $structure, Container $container, ContainerRequest $request)
    {
        $moduleBuilder = new ModuleBuilderService($structure, 'container', $container);
        dd($moduleBuilder->validation());
        $this->containerRepository->update($structure, $container);
        $this->containerTranslationRepository->update($container, $request);


        return redirect()->route('dawnstar.structures.edit')->with(['success' => __('Dawnstar::structure.success.update')]);
    }
}
