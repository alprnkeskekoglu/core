<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Http\Requests\MenuRequest;
use Dawnstar\Models\Menu;

class MenuController extends PanelController
{
    public function index()
    {
        $menus = Menu::all();
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
        $breadcrumb = [
            [
                'name' => __('DawnstarLang::menu.index_title'),
                'url' => route('dawnstar.menu.index')
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

        // Admin Action
        addAction($menu, 'update');

        return redirect()->route('dawnstar.menu.index')->with('success_message', __('DawnstarLang::menu.response_message.update'));
    }

    public function delete($id)
    {
        $menu = Menu::find($id);

        if (is_null($menu)) {
            return response()->json(['title' => __('DawnstarLang::general.swal.error.title'), 'subtitle' => __('DawnstarLang::general.swal.error.subtitle')], 406);
        }

        $menu->delete();

        // Admin Action
        addAction($menu, 'delete');

        return response()->json(['title' => __('DawnstarLang::general.swal.success.title'), 'subtitle' => __('DawnstarLang::general.swal.success.subtitle')]);
    }
}
