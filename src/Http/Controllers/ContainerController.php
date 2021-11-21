<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Models\Container;
use Dawnstar\Models\Structure;
use Dawnstar\Repositories\ContainerRepository;
use Dawnstar\Repositories\ContainerTranslationRepository;
use Dawnstar\Services\ModuleBuilderService;

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

    public function update(Structure $structure, Container $container)
    {
        $moduleBuilder = new ModuleBuilderService($structure, 'container', $container);
        $moduleBuilder->validate();

        $this->containerRepository->update($structure, $container);
        $this->containerTranslationRepository->update($container);

        return redirect()->route('dawnstar.structures.containers.edit', [$structure, $container])->with(['success' => __('Dawnstar::structure.success.update')]);
    }
}
