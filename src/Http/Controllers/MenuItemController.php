<?php

namespace Dawnstar\Core\Http\Controllers;

use Dawnstar\Core\Http\Requests\MenuItemRequest;
use Dawnstar\Core\Models\Language;
use Dawnstar\Core\Models\Menu;
use Dawnstar\Core\Models\MenuItem;
use Dawnstar\Core\Models\Url;
use Illuminate\Http\Request;

class MenuItemController extends BaseController
{
    public function index(Menu $menu)
    {
        canUser("menu.index");

        $activeLanguage = $this->getActiveLanguage();
        $items = $this->getItems($menu, $activeLanguage);

        return view('Core::modules.menu_item.index', compact('menu', 'items', 'activeLanguage'));
    }

    public function store(Menu $menu, MenuItemRequest $request)
    {
        canUser("menu.create");

        $data = $request->except('_token', 'medias');
        $medias = $request->get('medias');

        $data['menu_id'] = $menu->id;

        $menuItem = MenuItem::create($data);
        $menuItem->syncMedias($medias);

        return redirect()->route('dawnstar.menus.items.index', $menu)->with(['success' => __('Core::menu_item.success.store')]);
    }

    public function edit(Menu $menu, MenuItem $item)
    {
        canUser("menu.edit");

        $activeLanguage = $this->getActiveLanguage();
        $items = $this->getItems($menu, $activeLanguage);

        return view('Core::modules.menu_item.edit', compact('menu', 'item', 'items', 'activeLanguage'));
    }

    public function update(Menu $menu, MenuItem $item, MenuItemRequest $request)
    {
        canUser("menu.edit");

        $data = $request->except('_token', 'medias');
        $medias = $request->get('medias');

        $item->update($data);
        $item->syncMedias($medias);

        return redirect()->route('dawnstar.menus.items.index', $menu)->with(['success' => __('Core::menu_item.success.update')]);
    }

    public function destroy(Menu $menu)
    {
        canUser("menu.destroy");

        $menu->delete();

        return redirect()->route('dawnstar.menus.index')->with(['success' => __('Core::menu.success.destroy')]);
    }

    public function getUrls()
    {
        canUser("menu.index");

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
        canUser("menu.edit");

        $data = $request->get('data');

        $orderedData = buildTree($data);

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
    #endregion
}
