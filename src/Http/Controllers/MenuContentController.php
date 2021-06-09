<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Contracts\Services\ModelStoreService;
use Dawnstar\Http\Requests\MenuContentRequest;
use Dawnstar\Models\Menu;
use Dawnstar\Models\MenuContent;
use Dawnstar\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MenuContentController extends BaseController
{

    public function create(Menu $menu)
    {
        canUser("menu.create");

        $website = session('dawnstar.website');
        $languages = $website->languages;

        $menuContents = $menu->contents()
            ->where('parent_id', 0)
            ->orderBy('lft')
            ->with(['children' => function ($q) {
                $q->with(['children' => function ($que) {
                    $que->orderBy('lft');
                }])
                    ->orderBy('lft');
            }])
            ->get()
            ->groupBy('language_id');

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::menu.index_title'),
                'url' => route('dawnstar.menus.index')
            ],
            [
                'name' => __('DawnstarLang::menu_content.create_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.menu_content.create', compact('menu', 'menuContents', 'languages', 'breadcrumb'));
    }

    public function store(MenuContentRequest $request, Menu $menu)
    {
        canUser("menu.create");

        $data = $request->except('_token');

        foreach ($data['contents'] as $languageId => $values) {
            if($values['status'] == 3) {
                continue;
            }
            $menuContent = MenuContent::firstOrCreate([
                'admin_id' => auth('admin')->id(),
                'menu_id' => $menu->id,
                'language_id' => $languageId,
                'status' => $values['status'],
                'name' => $values['name'],
                'type' => $values['type'],
                'url_id' => $values['url_id'],
                'out_link' => $values['out_link'],
                'target' => $values['target'],
            ]);

            if(isset($values['image'])) {
                $storeService = new ModelStoreService();
                $storeService->storeMedias($menuContent, ['image' => $values['image']]);
            }

            // Admin Action
            addAction($menuContent, 'store');
        }

        Cache::flush();

        return redirect()->route('dawnstar.menus.contents.create', $menu)->with('success_message', __('DawnstarLang::menu_content.response_message.store'));
    }

    public function edit(Menu $menu, MenuContent $menuContent)
    {
        canUser("menu.edit");

        $menuContents = $menu->contents()
            ->where('language_id', $menuContent->language_id)
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
                'name' => __('DawnstarLang::menu.index_title'),
                'url' => route('dawnstar.menus.index')
            ],
            [
                'name' => __('DawnstarLang::menu_content.create_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.menu_content.edit', compact('menu', 'menuContent', 'menuContents', 'breadcrumb'));
    }

    public function update(MenuContentRequest $request, Menu $menu, MenuContent $menuContent)
    {
        canUser("menu.edit");

        $data = $request->except('_token');

        $image = $data['image'] ?? null;
        unset($data['image']);

        $menuContent->update($data);

        $storeService = new ModelStoreService();
        $storeService->storeMedias($menuContent, ['image' => $image]);

        Cache::flush();

        // Admin Action
        addAction($menuContent, 'update');

        return redirect()->route('dawnstar.menus.contents.create', ['menuId' => $menuId])->with('success_message', __('DawnstarLang::menu.response_message.update'));
    }

    public function destroy(Menu $menu, MenuContent $menuContent)
    {
        canUser("menu.destroy");

        if($menuContent->children->isNotEmpty()) {
            $menuContent->children()->update(['parent_id' => $menuContent->parent_id]);
        }

        $menuContent->delete();

        Cache::flush();

        // Admin Action
        addAction($menuContent, 'delete');

        return response()->json(['title' => __('DawnstarLang::general.swal.success.title'), 'subtitle' => __('DawnstarLang::general.swal.success.subtitle')]);
    }

    public function getUrls(Request $request)
    {
        $languageId = $request->get('language_id');
        $search = $request->get('search');

        $urls = Url::with('model')
            ->where('website_id', session('dawnstar.website.id'))
            ->where('type', 'original')
            ->whereHas('model', function ($q) use($languageId, $search) {
                $q = $q->where('language_id', $languageId);

                if($search) {
                    $q = $q->where('name', 'like', '%' . $search . '%');
                }
                return $q;
            })
            ->get()
            ->take(10);

        $return = [];

        foreach ($urls as $url) {
            $return['results'][] = [
                'id' => $url->id,
                'text' => $url->model->name
            ];
        }
        return $return;
    }
}
