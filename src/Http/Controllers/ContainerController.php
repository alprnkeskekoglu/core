<?php

namespace Dawnstar\Core\Http\Controllers;

use Dawnstar\Core\Models\Container;
use Dawnstar\Core\Models\Structure;
use Dawnstar\Core\Repositories\ContainerRepository;
use Dawnstar\Core\Repositories\ContainerTranslationRepository;
use Dawnstar\ModuleBuilder\Services\ModuleBuilderService;

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
        canUser("structure.{$structure->id}.edit");

        if($structure->has_detail != 1) {
            if($structure->type != 'dynamic') {
                abort(404);
            }
            return to_route('dawnstar.structures.pages.index', $structure);
        }

        $moduleBuilder = new ModuleBuilderService($structure, 'container', $container);
        $languages = $moduleBuilder->languages;

        return view('Core::modules.container.edit', compact('structure', 'container', 'moduleBuilder', 'languages'));
    }

    public function update(Structure $structure, Container $container)
    {
        canUser("structure.{$structure->id}.edit");

        $moduleBuilder = new ModuleBuilderService($structure, 'container', $container);
        $moduleBuilder->validate();

        $this->containerRepository->update($container);
        $this->containerTranslationRepository->update($container);

        return to_route('dawnstar.structures.containers.edit', [$structure, $container])->with(['success' => __('Core::structure.success.update')]);
    }
}
