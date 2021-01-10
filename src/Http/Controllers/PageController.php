<?php

namespace Dawnstar\Http\Controllers;

use Carbon\Carbon;
use Dawnstar\Foundation\FormBuilder;
use Dawnstar\Models\Container;
use Dawnstar\Models\Page;
use Dawnstar\Models\PageDetail;
use Dawnstar\Models\PageDetailExtra;
use Dawnstar\Models\PageExtra;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class PageController extends BaseController
{
    public function index(int $containerId)
    {
        $container = Container::findOrFail($containerId);

        $pages = $container->pages()->orderBy('order')->get();


        $breadcrumb = [
            [
                'name' => __('DawnstarLang::page.index_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.page.index', compact('container', 'pages', 'breadcrumb'));
    }

    public function create(int $containerId)
    {
        $container = Container::findOrFail($containerId);
        $languages = $container->languages();

        $formBuilder = new FormBuilder('page', 2);

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::page.index_title'),
                'url' => route('dawnstar.page.index', ['containerId' => $containerId])
            ],
            [
                'name' => __('DawnstarLang::page.create_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.page.create', compact('container', 'languages', 'formBuilder', 'breadcrumb'));
    }

    public function store(Request $request, int $containerId)
    {
        $container = Container::findOrFail($containerId);
        $data = $request->except('_token');

        $details = $data['details'] ?? [];
        $extras = $data['extras'] ?? [];
        unset($data['details'], $data['extras']);

        $data['container_id'] = $containerId;

        $page = Page::firstOrCreate($data);

        foreach ($extras as $key => $value) {
            PageExtra::firstOrCreate([
                'page_id' => $page->id,
                'key' => $key,
                'value' => $value,
            ]);
        }

        foreach ($details as $languageId => $detail) {

            $extras = $detail['extras'] ?? [];
            unset($detail['extras']);

            $pageDetail = PageDetail::updateOrCreate(
                [
                    'page_id' => $page->id,
                    'language_id' => $languageId
                ],
                $detail
            );

            $pageDetail->extras()->delete();
            foreach ($extras as $key => $value) {
                PageDetailExtra::firstOrCreate([
                    'page_detail_id' => $pageDetail->id,
                    'key' => $key,
                    'value' => $value,
                ]);
            }
        }

        // Admin Action
        addAction($page, 'store');

        return redirect()->route('dawnstar.page.index', ['containerId' => $containerId])->with('success_message', __('DawnstarLang::page.response_message.store'));
    }

    public function edit(int $containerId, int $id)
    {
        $container = Container::findOrFail($containerId);
        $page = Page::findOrFail($id);

        $languages = $container->languages();

        $formBuilder = new FormBuilder('page', 2, $id);

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::page.index_title'),
                'url' => route('dawnstar.page.index', ['containerId' => $containerId])
            ],
            [
                'name' => __('DawnstarLang::page.edit_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.page.edit', compact('container', 'page', 'languages', 'formBuilder', 'breadcrumb'));
    }

    public function update(Request $request, int $containerId, int $id)
    {
        $container = Container::findOrFail($containerId);
        $page = Page::findOrFail($id);
        $data = $request->except('_token');

        $details = $data['details'] ?? [];
        $extras = $data['extras'] ?? [];
        unset($data['details'], $data['extras']);


        $page->update($data);

        $page->extras()->delete();
        foreach ($extras as $key => $value) {
            PageExtra::firstOrCreate([
                'page_id' => $page->id,
                'key' => $key,
                'value' => $value,
            ]);
        }

        foreach ($details as $languageId => $detail) {

            $extras = $detail['extras'] ?? [];
            unset($detail['extras']);

            $pageDetail = PageDetail::updateOrCreate(
                [
                    'page_id' => $page->id,
                    'language_id' => $languageId
                ],
                $detail
            );

            $pageDetail->extras()->delete();
            foreach ($extras as $key => $value) {
                PageDetailExtra::firstOrCreate([
                    'page_detail_id' => $pageDetail->id,
                    'key' => $key,
                    'value' => $value,
                ]);
            }
        }

        // Admin Action
        addAction($page, 'update');

        return redirect()->route('dawnstar.page.edit', ['containerId' => $containerId, 'id' => $id])->with('success_message', __('DawnstarLang::page.response_message.update'));
    }

    public function delete(int $containerId, int $id)
    {
        $container = Container::findOrFail($containerId);
        $page = Page::findOrFail($id);

        $page->delete();

        // Admin Action
        addAction($page, 'delete');

        return response()->json(['title' => __('DawnstarLang::general.swal.success.title'), 'subtitle' => __('DawnstarLang::general.swal.success.subtitle')]);
    }
}
