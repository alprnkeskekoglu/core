<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Http\Requests\MenuItemRequest;
use Dawnstar\Models\Language;
use Dawnstar\Models\Menu;
use Dawnstar\Models\MenuItem;
use Dawnstar\Models\Url;
use Illuminate\Http\Request;

class MenuItemController extends BaseController
{
    public function index(Menu $menu)
    {
        $activeLanguage = $this->getActiveLanguage();
        $items = $this->getItems($menu, $activeLanguage);

        return view('Dawnstar::modules.menu_item.index', compact('menu', 'items', 'activeLanguage'));
    }

    public function store(Menu $menu, MenuItemRequest $request)
    {
        $data = $request->except('_token', 'medias');
        $medias = $request->get('medias');

        $data['menu_id'] = $menu->id;

        $menuItem = MenuItem::create($data);
        $menuItem->syncMedias($medias);

        return redirect()->route('dawnstar.menus.items.index', $menu)->with(['success' => __('Dawnstar::menu_item.success.store')]);
    }

    public function edit(Menu $menu, MenuItem $item)
    {
        $activeLanguage = $this->getActiveLanguage();
        $items = $this->getItems($menu, $activeLanguage);

        return view('Dawnstar::modules.menu_item.edit', compact('menu', 'item', 'items', 'activeLanguage'));
    }

    public function update(Menu $menu, MenuItem $item, MenuItemRequest $request)
    {
        $data = $request->except('_token', 'medias');
        $medias = $request->get('medias');

        $item->update($data);
        $item->syncMedias($medias);

        return redirect()->route('dawnstar.menus.items.index', $menu)->with(['success' => __('Dawnstar::menu_item.success.update')]);
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('dawnstar.menus.index')->with(['success' => __('Dawnstar::menu.success.destroy')]);
    }

    public function getUrls()
    {
        $languageId = request('language_id');
        $search = request('search');

        $urls = Url::with('model')
            ->where('website_id', session('dawnstar.website.id'))
            ->where('type', 1)
            ->where('url', 'like', "%$search%")
            ->whereHas('model', function ($q) use ($languageId, $search) {
                $q->where('language_id', $languageId);
            })
            ->get()
            ->take(10);


        $return = [];

        foreach ($urls as $url) {
            $return['results'][] = [
                'id' => $url->id,
                'text' => $url->url
            ];
        }
        return $return;
    }

    public function saveOrder(Request $request)
    {
        $data = $request->get('data');

        $orderedData = $this->buildTree($data);

        foreach ($orderedData as $ordered) {
            $item = MenuItem::find($ordered['id']);

            if($item) {
                unset($ordered['id']);
                $item->update($ordered);
            }
        }
    }

    #region Helpers
    private function getActiveLanguage()
    {
        $languages = session('dawnstar.languages');
        $activeLanguage = $languages->where('id', request('language_id'))->first();
        return $activeLanguage ?: $languages->first();
    }

    private function getItems(Menu $menu, Language $language)
    {
        return $menu->items()
            ->where('language_id', $language->id)
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

    private function buildTree(array $elements, $parentId = 0, $max = 0)
    {
        $branch = array();
        foreach ($elements as $element)
        {
            $element['left'] = $max = $max + 1;
            $element['rigt'] = $max + 1;
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
    #endregion
}
