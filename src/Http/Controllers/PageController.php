<?php

namespace Dawnstar\Http\Controllers;


use Dawnstar\Models\Page;
use Dawnstar\Models\Structure;
use Dawnstar\Repositories\PageRepository;
use Dawnstar\Repositories\PageTranslationRepository;
use Dawnstar\Services\ModuleBuilderService;
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
        $columns = [
            ['data' => 'id', 'name' => 'id', 'label' => '#'],
            ['data' => 'status', 'name' => 'status', 'label' => __('Dawnstar::page.labels.status')],
            ['data' => 'name', 'name' => 'translation.name', 'label' => __('Dawnstar::page.labels.name')],
            ['data' => 'created_at', 'name' => 'created_at', 'label' => __('Dawnstar::page.labels.created_at')],
            ['data' => 'updated_at', 'name' => 'updated_at', 'label' => __('Dawnstar::page.labels.updated_at')],
            ['data' => 'action', 'name' => 'action', 'label' => __('Dawnstar::general.action')],
        ];
        return view('Dawnstar::modules.page.index', compact('structure', 'columns'));
    }

    public function create(Structure $structure)
    {
        $moduleBuilder = new ModuleBuilderService($structure, 'page');
        $languages = $moduleBuilder->languages;

        return view('Dawnstar::modules.page.create', compact('structure', 'moduleBuilder', 'languages'));
    }

    public function store(Structure $structure)
    {
        $moduleBuilder = new ModuleBuilderService($structure, 'page');
        $moduleBuilder->validate();

        $page = $this->pageRepository->store($structure);
        $this->pageTranslationRepository->store($page);

        return redirect()->route('dawnstar.structures.pages.index', $structure)->with(['success' => __('Dawnstar::page.success.store')]);
    }

    public function datatable(Structure $structure)
    {
        $pages = Page::where('structure_id', $structure->id)->with('translation');

        return DataTables::of($pages)
            ->editColumn('name', function($page) {
                return optional($page->translation)->name;
            })
            ->addColumn('action', function ($page) use($structure) {
                return '' .
                    '<a href="' . route('dawnstar.structures.edit', $structure) . '" class="action-icon"><i class="mdi mdi-pencil"></i></a>' .
                    '<form action="' . route('dawnstar.structures.destroy', $structure) . '" method="POST" class="d-inline">' .
                        '<input type="hidden" name="_method" value="DELETE">' .
                        csrf_field() .
                        '<button type="submit" class="btn action-icon"><i class="mdi mdi-delete"></i></button>'.
                    '</form>';
            })
            ->make(true);
    }
}
