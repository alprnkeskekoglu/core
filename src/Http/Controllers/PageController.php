<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Datatables\PageDatatable;
use Dawnstar\Models\Page;
use Dawnstar\Models\Structure;
use Dawnstar\Repositories\PageRepository;
use Dawnstar\Repositories\PageTranslationRepository;
use Dawnstar\Services\ModuleBuilderService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PageController extends BaseController
{
    protected PageRepository $pageRepository;
    protected PageTranslationRepository $pageTranslationRepository;

    public function __construct(PageRepository $pageRepository, PageTranslationRepository $pageTranslationRepository)
    {
        $this->pageRepository = $pageRepository;
        $this->pageTranslationRepository = $pageTranslationRepository;
    }

    public function index(Structure $structure)
    {
        if($structure->type != 'dynamic') {
            return redirect()->route('dawnstar.structures.containers.edit', [$structure, $structure->container]);
        }

        canUser("structure.{$structure->id}.index");

        $columns = [
            ['data' => 'id', 'name' => 'id', 'label' => '#', 'searchable' => false],
            ['data' => 'order', 'name' => 'order', 'label' => __('Dawnstar::page.labels.order'), 'searchable' => false],
            ['data' => 'status', 'name' => 'status', 'label' => __('Dawnstar::page.labels.status'), 'searchable' => false],
            ['data' => 'name', 'name' => 'translation.name', 'label' => __('Dawnstar::page.labels.name'), 'orderable' => false],
            ['data' => 'created_at', 'name' => 'created_at', 'label' => __('Dawnstar::page.labels.created_at'), 'searchable' => false],
            ['data' => 'updated_at', 'name' => 'updated_at', 'label' => __('Dawnstar::page.labels.updated_at'), 'searchable' => false],
            ['data' => 'actions', 'name' => 'actions', 'label' => __('Dawnstar::general.actions'), 'orderable' => false, 'searchable' => false],
        ];
        return view('Dawnstar::modules.page.index', compact('structure', 'columns'));
    }

    public function create(Structure $structure)
    {
        if($structure->type != 'dynamic') {
            abort(404);
        }

        canUser("structure.{$structure->id}.create");

        $moduleBuilder = new ModuleBuilderService($structure, 'page');
        $languages = $moduleBuilder->languages;

        return view('Dawnstar::modules.page.create', compact('structure', 'moduleBuilder', 'languages'));
    }

    public function store(Structure $structure)
    {
        canUser("structure.{$structure->id}.create");

        $moduleBuilder = new ModuleBuilderService($structure, 'page');
        $moduleBuilder->validate();

        $page = $this->pageRepository->store($structure);
        $this->pageTranslationRepository->store($page);

        return redirect()->route('dawnstar.structures.pages.index', $structure)->with(['success' => __('Dawnstar::page.success.store')]);
    }

    public function edit(Structure $structure, Page $page)
    {
        canUser("structure.{$structure->id}.edit");

        $moduleBuilder = new ModuleBuilderService($structure, 'page', $page);
        $languages = $moduleBuilder->languages;

        return view('Dawnstar::modules.page.edit', compact('structure', 'page', 'moduleBuilder', 'languages'));
    }

    public function update(Structure $structure, Page $page)
    {
        canUser("structure.{$structure->id}.edit");

        $moduleBuilder = new ModuleBuilderService($structure, 'page', $page);
        $moduleBuilder->validate();

        $page = $this->pageRepository->update($page);
        $this->pageTranslationRepository->update($page);

        return redirect()->route('dawnstar.structures.pages.index', $structure)->with(['success' => __('Dawnstar::page.success.update')]);
    }

    public function destroy(Structure $structure, Page $page)
    {
        canUser("structure.{$structure->id}.destroy");

        $this->pageRepository->destroy($page);
        return redirect()->route('dawnstar.structures.pages.index', $structure)->with(['success' => __('Dawnstar::page.success.destroy')]);
    }

    public function datatable(Structure $structure, Request $request)
    {
        canUser("structure.{$structure->id}.index");

        $datatableName = str_replace('_', '', ucwords($structure->key, '_')) . 'Datatable';
        $class = app_path('Datatables/' . $datatableName);

        if (file_exists($class)) {
            $datatable = new $class();
        } else {
            $datatable = new PageDatatable();
        }

        return $datatable->query($structure, $request);
    }
}
