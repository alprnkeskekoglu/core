<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Contracts\Services\ModelStoreService;
use Dawnstar\Foundation\FormBuilder;
use Dawnstar\Models\Category;
use Dawnstar\Models\Container;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function index(Container $container)
    {
        canUser("container.{$container->id}.index");

        $languages = $container->languages();

        $categories = $container->categories()
            ->where('parent_id', 0)
            ->orderBy('lft')
            ->with(['children' => function ($q) {
                $q->with(['children' => function ($que) {
                    $que->orderBy('lft');
                }])
                    ->orderBy('lft');
            }])
            ->get();

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::category.index_title'),
                'url' => route('dawnstar.containers.pages.index', $container)
            ],
            [
                'name' => __('DawnstarLang::category.create_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.category.index', compact('container', 'categories', 'languages', 'breadcrumb'));
    }

    public function create(Container $container)
    {
        canUser("container.{$container->id}.create");


        $languages = $container->languages();
        $formBuilder = new FormBuilder('category', $container->id);

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::category.index_title'),
                'url' => route('dawnstar.containers.categories.index', $container)
            ],
            [
                'name' => __('DawnstarLang::category.create_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.category.create', compact('container', 'formBuilder', 'languages', 'breadcrumb'));
    }

    public function store(Request $request, Container $container)
    {
        canUser("container.{$container->id}.create");

        $storeService = new ModelStoreService();

        $data = $request->except('_token');

        $details = $data['details'] ?? [];
        $medias = $data['medias'] ?? [];
        $metas = $data['metas'] ?? [];
        unset($data['details'], $data['medias'], $data['metas']);

        $data['container_id'] = $container->id;

        $category = $storeService->store(Category::class, $data);

        $storeService->storeDetails($category, $details);

        $storeService->storeMedias($category, $medias);

        $storeService->storeMetas($category, $metas);

        // Admin Action
        addAction($category, 'store');

        return redirect()->route('dawnstar.containers.categories.index', $container)->with('success_message', __('DawnstarLang::page.response_message.store'));
    }

    public function edit(Container $container, Category $category)
    {
        canUser("container.{$container->id}.edit");

        $languages = $container->languages();
        $formBuilder = new FormBuilder('category', $container->id, $category->id);

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::category.index_title'),
                'url' => route('dawnstar.containers.categories.index', $container)
            ],
            [
                'name' => __('DawnstarLang::category.edit_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.category.edit', compact('container', 'category', 'formBuilder', 'languages', 'breadcrumb'));
    }

    public function update(Request $request, Container $container, Category $category)
    {
        canUser("container.{$container->id}.edit");

        $storeService = new ModelStoreService();

        $data = $request->except('_token');

        $details = $data['details'] ?? [];
        $medias = $data['medias'] ?? [];
        $metas = $data['metas'] ?? [];
        unset($data['details'], $data['medias'], $data['metas']);

        $storeService->update($category, $data);

        $storeService->storeDetails($category, $details);

        $storeService->storeMedias($category, $medias);

        $storeService->storeMetas($category, $metas);

        // Admin Action
        addAction($category, 'update');

        return redirect()->route('dawnstar.containers.categories.edit', [$container, $category])->with('success_message', __('DawnstarLang::page.response_message.update'));
    }

    public function destroy(Request $request, Container $container, Category $category)
    {
        canUser("container.{$container->id}.destroy");


        if ($request->get('child_delete') == 1) {
            Category::where("lft", ">", $category->lft)
                ->where("rgt", "<", $category->rgt)
                ->where('parent_id', $category->id)
                ->delete();
        } else {
            $category->children()->update(['parent_id' => $category->parent_id]);
        }

        $category->delete();

        // Admin Action
        addAction($category, 'delete');

        return redirect()->route('dawnstar.containers.categories.index', $container)->with('success_message', __('DawnstarLang::page.response_message.update'));
    }

    public function saveOrder(Request $request, Container $container)
    {
        canUser("container.{$container->id}.edit");


        $data = $request->get('data');

        $orderedData = $this->buildTree($data);

        foreach ($orderedData as $ordered) {
            $category = Category::find($ordered['id']);

            if($category) {
                unset($ordered['id']);

                $category->update($ordered);
            }
        }

        // Admin Action
        addAction($category, 'saveOrder');
    }

    public function buildTree(array $elements, $parentId = 0, $max = 0)
    {
        $branch = array();
        foreach ($elements as $element)
        {
            $element['lft'] = $max = $max + 1;
            $element['rgt'] = $max + 1;
            $element['parent_id'] = $parentId;

            if (isset($element['children']))
            {
                $children = $this->buildTree($element['children'], $element['id'], $max);
                if ($children)
                {

                    $element['rgt'] = $max = (isset(end($children)['rgt']) ? end($children)['rgt'] : 1) + 1;
                    $element['children'] = $children;
                } else
                {
                    $element['rgt'] = $max = $max + 1;
                }
            }

            $branch[] = $element;
        }

        return $this->unBuildTree($branch);
    }

    public function unBuildTree($elements, $branch = [])
    {
        foreach ($elements as $element)
        {
            if (isset($element['children']))
            {
                $branch = $this->unBuildTree($element['children'], $branch);
                unset($element['children']);
            }
            $branch[] = $element;
        }
        return $branch;
    }
}
