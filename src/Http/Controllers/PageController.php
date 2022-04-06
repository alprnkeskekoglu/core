<?php

namespace Dawnstar\Core\Http\Controllers;

use Dawnstar\Core\Datatables\PageDatatable;
use Dawnstar\Core\Models\CategoryProperty;
use Dawnstar\Core\Models\Page;
use Dawnstar\Core\Models\Property;
use Dawnstar\Core\Models\Structure;
use Dawnstar\Core\Repositories\PageRepository;
use Dawnstar\Core\Repositories\PageTranslationRepository;
use Dawnstar\ModuleBuilder\Services\ModuleBuilderService;
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
        if ($structure->type != 'dynamic') {
            if($structure->has_detail == false) {
                abort(404);
            }
            return to_route('dawnstar.structures.containers.edit', [$structure, $structure->container]);
        }

        canUser("structure.{$structure->id}.index");

        $columns = [
            ['data' => 'id', 'name' => 'id', 'label' => '#', 'searchable' => false],
            ['data' => 'order', 'name' => 'order', 'label' => __('Core::page.labels.order'), 'searchable' => false],
            ['data' => 'status', 'name' => 'status', 'label' => __('Core::page.labels.status'), 'searchable' => false],
            ['data' => 'name', 'name' => 'translation.name', 'label' => __('Core::page.labels.name'), 'orderable' => false],
            ['data' => 'created_at', 'name' => 'created_at', 'label' => __('Core::page.labels.created_at'), 'searchable' => false],
            ['data' => 'updated_at', 'name' => 'updated_at', 'label' => __('Core::page.labels.updated_at'), 'searchable' => false],
            ['data' => 'actions', 'name' => 'actions', 'label' => __('Core::general.actions'), 'orderable' => false, 'searchable' => false],
        ];

        return view('Core::modules.page.index', compact('structure', 'columns'));
    }

    public function create(Structure $structure)
    {
        if ($structure->type != 'dynamic') {
            abort(404);
        }

        canUser("structure.{$structure->id}.create");

        $moduleBuilder = new ModuleBuilderService($structure, 'page');
        $languages = $moduleBuilder->languages;

        return view('Core::modules.page.create', compact('structure', 'moduleBuilder', 'languages'));
    }

    public function store(Structure $structure)
    {
        canUser("structure.{$structure->id}.create");

        $moduleBuilder = new ModuleBuilderService($structure, 'page');
        $moduleBuilder->validate();

        $page = $this->pageRepository->store($structure);
        $this->pageTranslationRepository->store($page);

        return to_route('dawnstar.structures.pages.index', $structure)->with(['success' => __('Core::page.success.store')]);
    }

    public function edit(Structure $structure, Page $page)
    {
        canUser("structure.{$structure->id}.edit");

        $moduleBuilder = new ModuleBuilderService($structure, 'page', $page);
        $languages = $moduleBuilder->languages;

        return view('Core::modules.page.edit', compact('structure', 'page', 'moduleBuilder', 'languages'));
    }

    public function update(Structure $structure, Page $page)
    {
        canUser("structure.{$structure->id}.edit");

        $moduleBuilder = new ModuleBuilderService($structure, 'page', $page);
        $moduleBuilder->validate();

        $page = $this->pageRepository->update($page);
        $this->pageTranslationRepository->update($page);

        return to_route('dawnstar.structures.pages.index', $structure)->with(['success' => __('Core::page.success.update')]);
    }

    public function destroy(Structure $structure, Page $page)
    {
        canUser("structure.{$structure->id}.destroy");

        $this->pageRepository->destroy($page);
        return to_route('dawnstar.structures.pages.index', $structure)->with(['success' => __('Core::page.success.destroy')]);
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

    public function getCategoryProperties(Structure $structure, Request $request)
    {
        $categoryIds = $request->get('categories');
        $value = $request->get('value', []);

        $propertyIds = CategoryProperty::whereIn('category_id', $categoryIds)->pluck('property_id')->toArray();

        $properties = Property::whereIn('id', $propertyIds)
            ->active()
            ->with(['translation', 'options' => function ($q) {
                $q->active();
            }])
            ->get();

        return view('ModuleBuilder::inputs.property_ajax', compact('properties', 'value'))->render();
    }
}
