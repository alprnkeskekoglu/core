<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Http\Requests\MenuRequest;
use Dawnstar\Models\Menu;
use Dawnstar\Models\MenuContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MenuController extends BaseController
{

    public function index()
    {
        canUser("menu.index");

        $menus = Menu::where('website_id', session('dawnstar.website.id'))->get();
        $breadcrumb = [
            [
                'name' => __('DawnstarLang::menu.index_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.menu.index', compact('menus', 'breadcrumb'));
    }

    public function create()
    {
        canUser("menu.create");

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::menu.index_title'),
                'url' => route('dawnstar.menus.index')
            ],
            [
                'name' => __('DawnstarLang::menu.create_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.menu.create', compact('breadcrumb'));
    }

    public function store(MenuRequest $request)
    {
        canUser("menu.create");

        $data = $request->except('_token');

        $request->validated();

        $data['website_id'] = session('dawnstar.website.id');

        $key = \Str::slug($data['name']);
        $menu = Menu::firstOrCreate(
            ['key' => $key],
            $data
        );

        // Admin Action
        addAction($menu, 'store');

        return redirect()->route('dawnstar.menus.index')->with('success_message', __('DawnstarLang::menu.response_message.store'));
    }

    public function edit(Menu $menu)
    {
        canUser("menu.edit");

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::menu.index_title'),
                'url' => route('dawnstar.menus.index')
            ],
            [
                'name' => __('DawnstarLang::menu.edit_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.menu.edit', compact('menu', 'breadcrumb'));
    }

    public function update(MenuRequest $request, Menu $menu)
    {
        canUser("menu.edit");

        $data = $request->except('_token');

        $menu->update($data);

        // Admin Action
        addAction($menu, 'update');

        return redirect()->route('dawnstar.menus.index')->with('success_message', __('DawnstarLang::menu.response_message.update'));
    }

    public function destroy(Menu $menu)
    {
        canUser("menu.destroy");

        $menu->delete();

        // Admin Action
        addAction($menu, 'delete');

        return redirect()->route('dawnstar.menus.index')->with('success_message', __('DawnstarLang::menu.response_message.destroy'));
    }

    public function saveOrder(Request $request, Menu $menu)
    {
        canUser("menu.edit");

        $data = $request->get('data');

        $orderedData = $this->buildTree($data);

        foreach ($orderedData as $ordered) {
            $menuContent = MenuContent::find($ordered['id']);

            if($menuContent) {
                unset($ordered['id']);

                $menuContent->update($ordered);
            }
        }

        Cache::flush();

        // Admin Action
        addAction($menu, 'saveOrder');
    }

    private function buildTree(array $elements, $parentId = 0, $max = 0)
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

    private function unBuildTree($elements, $branch = [])
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
