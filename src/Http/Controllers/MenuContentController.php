<?php

namespace Dawnstar\Http\Controllers;


use Dawnstar\Models\Menu;

class MenuContentController extends PanelController
{
    public function create(int $menuId)
    {
        $menu = Menu::find($menuId);

        if (is_null($menu)) {
            return redirect()->route('menu.index')->withErrors(__('DawnstarLang::menu.response_message.id_error', ['id' => $menuId]));
        }

        $menuContents = $menu->contents->groupBy('language_id');

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::menu.index_title'),
                'url' => route('menu.index')
            ],
            [
                'name' => __('DawnstarLang::menu_content.create_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.menu_content.create', compact('menu', 'menuContents', 'breadcrumb'));
    }

    public function store(MenuRequest $request)
    {
        $data = $request->except('_token');

        $request->validated();

        $key = \Str::slug($data['name']);
        Menu::firstOrCreate(
            ['key' => $key],
            $data
        );

        return redirect()->route('menu.index')->with('success_message', __('DawnstarLang::menu.response_message.store'));
    }

    public function edit(int $id)
    {
        $menu = Menu::find($id);

        if (is_null($menu)) {
            return redirect()->route('menu.index')->withErrors(__('DawnstarLang::menu.response_message.id_error', ['id' => $id]))->withInput();
        }

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::menu.index_title'),
                'url' => route('menu.index')
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
            return redirect()->route('menu.index')->withErrors(__('DawnstarLang::menu.response_message.id_error', ['id' => $id]))->withInput();
        }

        $data = $request->except('_token');
        $request->validated();

        $menu->update($data);

        return redirect()->route('menu.index')->with('success_message', __('DawnstarLang::menu.response_message.update'));
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
}
