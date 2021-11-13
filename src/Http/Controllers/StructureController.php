<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Http\Requests\StructureRequest;
use Dawnstar\Models\Container;
use Dawnstar\Models\ContainerTranslation;
use Dawnstar\Models\Structure;
use Dawnstar\Repositories\ContainerRepository;
use Dawnstar\Repositories\ContainerTranslationRepository;
use Dawnstar\Repositories\ModuleBuilderRepository;
use Dawnstar\Repositories\StructureRepository;
use Illuminate\Support\Facades\DB;

class StructureController extends BaseController
{
    protected StructureRepository $structureRepository;
    protected ContainerRepository $containerRepository;
    protected ContainerTranslationRepository $containerTranslationRepository;

    public function __construct(StructureRepository $structureRepository, ContainerRepository $containerRepository, ContainerTranslationRepository $containerTranslationRepository)
    {
        $this->structureRepository = $structureRepository;
        $this->containerRepository = $containerRepository;
        $this->containerTranslationRepository = $containerTranslationRepository;
    }

    public function index()
    {
        $structures = $this->structureRepository->getAll();
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
        DB::beginTransaction();
        $structure = $this->structureRepository->store($request);
        $container = $this->containerRepository->store($structure);
        $this->containerTranslationRepository->store($container, $request);

        $moduleBuilderRepository = new ModuleBuilderRepository();
        $moduleBuilderRepository->store($structure);
        DB::commit();

        return redirect()->route('dawnstar.structures.index')->with(['success' => __('Dawnstar::structure.success.store')]);
    }


    public function edit(Structure $structure)
    {
        $languages = session('dawnstar.languages');

        return view('Dawnstar::modules.structure.edit', compact('structure', 'languages'));
    }

    public function update(Structure $structure, StructureRequest $request)
    {
        $this->structureRepository->update($structure, $request);
        $this->containerTranslationRepository->update($structure->container, $request);

        return redirect()->route('dawnstar.structures.index')->with(['success' => __('Dawnstar::structure.success.update')]);
    }

    public function destroy(Structure $structure)
    {
        $this->structureRepository->destroy($structure);

        return redirect()->route('dawnstar.structures.index')->with(['success' => __('Dawnstar::structure.success.destroy')]);
    }
}
