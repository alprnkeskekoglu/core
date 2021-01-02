<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Http\Requests\WebsiteRequest;
use Dawnstar\Models\Language;
use Dawnstar\Models\Website;

class WebsiteController extends PanelController
{
    public function index()
    {
        $websites = Website::all();
        $breadcrumb = [
            [
                'name' => __('DawnstarLang::website.index_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.website.index', compact('websites', 'breadcrumb'));
    }

    public function create()
    {
        $languages = Language::all();
        $breadcrumb = [
            [
                'name' => __('DawnstarLang::website.index_title'),
                'url' => route('dawnstar.website.index')
            ],
            [
                'name' => __('DawnstarLang::website.create_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.website.create', compact('languages', 'breadcrumb'));
    }

    public function store(WebsiteRequest $request)
    {
        $data = $request->except('_token');

        $request->validated();

        $languages = [];
        foreach ($data['languages'] as $lang) {
            $languages[$lang] = ['is_default' => 2];
        }
        $defaultLangauge = $data['default_language'];

        unset($data['languages'], $data['default_language']);
        $website = Website::firstOrCreate($data);

        $website->languages()->sync($languages);
        $website->languages()->updateExistingPivot($defaultLangauge, ['is_default' => 1]);

        // Admin Action
        addAction($website, 'store');

        return redirect()->route('dawnstar.website.index')->with('success_message', __('DawnstarLang::website.response_message.store'));
    }

    public function edit(int $id)
    {
        $website = Website::find($id);

        if (is_null($website)) {
            return redirect()->route('dawnstar.website.index')->withErrors(__('DawnstarLang::website.response_message.id_error', ['id' => $id]))->withInput();
        }
        $languages = Language::all();

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::website.index_title'),
                'url' => route('dawnstar.website.index')
            ],
            [
                'name' => __('DawnstarLang::website.edit_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.website.edit', compact('website', 'languages', 'breadcrumb'));
    }

    public function update(WebsiteRequest $request, $id)
    {
        $website = Website::find($id);

        if (is_null($website)) {
            return redirect()->route('dawnstar.website.index')->withErrors(__('DawnstarLang::website.response_message.id_error', ['id' => $id]))->withInput();
        }

        $data = $request->except('_token');

        $request->validated();

        $languages = [];
        foreach ($data['languages'] as $lang) {
            $languages[$lang] = ['is_default' => 2];
        }
        $defaultLangauge = $data['default_language'];

        unset($data['languages'], $data['default_language']);
        $website->update($data);

        $website->languages()->sync($languages);
        $website->languages()->updateExistingPivot($defaultLangauge, ['is_default' => 1]);


        // Admin Action
        addAction($website, 'update');

        return redirect()->route('dawnstar.website.index')->with('success_message', __('DawnstarLang::website.response_message.update'));
    }

    public function delete($id)
    {
        $website = Website::find($id);

        if (is_null($website)) {
            return response()->json(['title' => __('DawnstarLang::general.swal.error.title'), 'subtitle' => __('DawnstarLang::general.swal.error.subtitle')], 406);
        }

        $website->delete();
        //TODO delete everything

        // Admin Action
        addAction($website, 'delete');

        return response()->json(['title' => __('DawnstarLang::general.swal.success.title'), 'subtitle' => __('DawnstarLang::general.swal.success.subtitle')]);
    }
}
