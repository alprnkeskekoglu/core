<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Http\Requests\MenuContentRequest;
use Dawnstar\Models\Menu;
use Dawnstar\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class MenuContentController extends BaseController
{
    public function create(int $menuId)
    {
        $menu = Menu::find($menuId);

        if (is_null($menu)) {
            return redirect()->route('dawnstar.menu.index')->withErrors(__('DawnstarLang::menu.response_message.id_error', ['id' => $menuId]));
        }

        $website = session('dawnstar.website');
        $languages = $website->languages;

        $menuContents = $menu->contents->groupBy('language_id');

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::menu.index_title'),
                'url' => route('dawnstar.menu.index')
            ],
            [
                'name' => __('DawnstarLang::menu_content.create_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.menu_content.create', compact('menu', 'menuContents', 'languages', 'breadcrumb'));
    }

    public function store(MenuContentRequest $request)
    {
        $data = $request->except('_token');

        $request->validated();
        dd($data);

        $key = \Str::slug($data['name']);
        Menu::firstOrCreate(
            ['key' => $key],
            $data
        );

        return redirect()->route('dawnstar.menu.index')->with('success_message', __('DawnstarLang::menu.response_message.store'));
    }

    public function edit(int $id)
    {
        $menu = Menu::find($id);

        if (is_null($menu)) {
            return redirect()->route('dawnstar.menu.index')->withErrors(__('DawnstarLang::menu.response_message.id_error', ['id' => $id]))->withInput();
        }

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::menu.index_title'),
                'url' => route('dawnstar.menu.index')
            ],
            [
                'name' => __('DawnstarLang::menu.edit_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.menu.edit', compact('menu', 'breadcrumb'));
    }

    public function update(MenuRequest $request, $id)
    {
        $menu = Menu::find($id);

        if (is_null($menu)) {
            return redirect()->route('dawnstar.menu.index')->withErrors(__('DawnstarLang::menu.response_message.id_error', ['id' => $id]))->withInput();
        }

        $data = $request->except('_token');
        $request->validated();

        $menu->update($data);

        return redirect()->route('dawnstar.menu.index')->with('success_message', __('DawnstarLang::menu.response_message.update'));
    }

    public function delete($id)
    {
        $menu = Menu::find($id);

        if (is_null($menu)) {
            return response()->json(['title' => __('DawnstarLang::general.swal.error.title'), 'subtitle' => __('DawnstarLang::general.swal.error.subtitle')], 406);
        }

        $menu->delete();

        return response()->json(['title' => __('DawnstarLang::general.swal.success.title'), 'subtitle' => __('DawnstarLang::general.swal.success.subtitle')]);
    }

    public function getUrls(Request $request)
    {
        $languageId = $request->get('language_id');
        $search = $request->get('search');

        $urls = Url::with('model')
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
