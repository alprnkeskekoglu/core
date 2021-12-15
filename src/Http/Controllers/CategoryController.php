<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Models\Category;
use Dawnstar\Models\Structure;
use Dawnstar\Repositories\CategoryRepository;
use Dawnstar\Repositories\CategoryTranslationRepository;
use Dawnstar\Services\ModuleBuilderService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends BaseController
{
    public function __construct(CategoryRepository $categoryRepository, CategoryTranslationRepository $categoryTranslationRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryTranslationRepository = $categoryTranslationRepository;
    }

    public function index(Structure $structure)
    {
        $moduleBuilder = new ModuleBuilderService($structure, 'category');
        $languages = $moduleBuilder->languages;

        $categories = $this->getCategories($structure);

        return view('Dawnstar::modules.category.index', compact('structure', 'categories', 'moduleBuilder', 'languages'));
    }

    public function store(Structure $structure)
    {
        $moduleBuilder = new ModuleBuilderService($structure, 'category');
        $moduleBuilder->validate();

        $category = $this->categoryRepository->store($structure);
        $this->categoryTranslationRepository->store($category);

        return redirect()->route('dawnstar.structures.categories.index', $structure)->with(['success' => __('Dawnstar::category.success.store')]);
    }

    public function edit(Structure $structure, Category $category)
    {
        $moduleBuilder = new ModuleBuilderService($structure, 'category', $category);
        $languages = $moduleBuilder->languages;

        $categories = $this->getCategories($structure);

        return view('Dawnstar::modules.category.edit', compact('structure', 'categories', 'category', 'moduleBuilder', 'languages'));
    }

    public function update(Structure $structure, Category $category)
    {
        $moduleBuilder = new ModuleBuilderService($structure, 'category', $category);
        $moduleBuilder->validate();

        $category = $this->categoryRepository->update($category);
        $this->categoryTranslationRepository->update($category);

        return redirect()->route('dawnstar.structures.categories.index', $structure)->with(['success' => __('Dawnstar::category.success.update')]);
    }

    public function destroy(Structure $structure, Category $category)
    {
        $this->categoryRepository->destroy($category);
        return redirect()->route('dawnstar.structures.categories.index', $structure)->with(['success' => __('Dawnstar::category.success.destroy')]);
    }

    public function saveOrder(Request $request)
    {
        $data = $request->get('data');

        $orderedData = buildTree($data);

        foreach ($orderedData as $ordered) {
            $item = Category::find($ordered['id']);

            if($item) {
                unset($ordered['id']);
                $item->update($ordered);
            }
        }
    }

    private function getCategories(Structure $structure)
    {
        return $structure->categories()
            ->where('parent_id', 0)
            ->orderBy('left')
            ->with(['children' => function ($q) {
                $q->with(['children' => function ($que) {
                    $que->with(['children' => function ($quer) {
                        $quer->orderBy('left');
                    }])->orderBy('left');
                }])
                    ->orderBy('left');
            }])
            ->get();
    }
}
