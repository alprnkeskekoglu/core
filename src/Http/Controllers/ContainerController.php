<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Foundation\ContainerFileKit;
use Dawnstar\Http\Requests\ContainerRequest;
use Dawnstar\Models\Container;
use Dawnstar\Models\ContainerDetail;
use Dawnstar\Models\Language;
use Dawnstar\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ContainerController extends BaseController
{
    public function index()
    {
        $containers = Container::all();

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::container.index_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.container.index', compact('containers', 'breadcrumb'));
    }

    public function create()
    {
        $website = session('dawnstar.website');
        $languages = $website->languages;

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::container.index_title'),
                'url' => route('dawnstar.container.index')
            ],
            [
                'name' => __('DawnstarLang::container.create_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.container.create', compact('languages', 'breadcrumb'));
    }

    public function store(ContainerRequest $request)
    {
        $data = $request->except('_token');

        $request->validated();

        $data['website_id'] = session('dawnstar.website.id');
        $data['key'] = strtolower(str_replace(' ', '', $data['key']));

        $details = $data['details'];

        unset($data['details']);
        $container = Container::firstOrCreate($data);

        foreach ($details as $languageId => $detail) {
            if (!isset($detail['name'])) {
                continue;
            }
            ContainerDetail::firstOrCreate([
                'container_id' => $container->id,
                'language_id' => $languageId,
                'status' => $detail['status'],
                'name' => $detail['name'],
                'slug' => $detail['slug'],
            ]);
        }

        $kit = new ContainerFileKit($container);
        $kit->createFiles();

        // Admin Action
        addAction($container, 'store');

        return redirect()->route('dawnstar.container.index')->with('success_message', __('DawnstarLang::container.response_message.store'));
    }

    public function edit(int $id)
    {
        $container = Container::find($id);

        if (is_null($container)) {
            return redirect()->route('dawnstar.container.index')->withErrors(__('DawnstarLang::container.response_message.id_error', ['id' => $id]))->withInput();
        }
        $website = session('dawnstar.website');
        $languages = $website->languages;

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::container.index_title'),
                'url' => route('dawnstar.container.index')
            ],
            [
                'name' => __('DawnstarLang::container.edit_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.container.edit', compact('container', 'languages', 'breadcrumb'));
    }

    public function update(ContainerRequest $request, $id)
    {
        $container = Container::find($id);

        if (is_null($container)) {
            return redirect()->route('dawnstar.container.index')->withErrors(__('DawnstarLang::container.response_message.id_error', ['id' => $id]))->withInput();
        }
        $request->validated();

        $data = $request->except('_token');

        $details = $data['details'];

        unset($data['details']);
        $container->update($data);

        foreach ($details as $languageId => $detail) {
            if (!isset($detail['name'])) {
                continue;
            }
            ContainerDetail::updateOrCreate(
                [
                    'container_id' => $container->id,
                    'language_id' => $languageId,
                ],
                [
                    'status' => $detail['status'],
                    'name' => $detail['name'],
                    'slug' => $detail['slug'],
                ]
            );
        }

        // Admin Action
        addAction($container, 'update');

        return redirect()->route('dawnstar.container.index')->with('success_message', __('DawnstarLang::container.response_message.update'));
    }

    public function delete($id)
    {
        $container = Container::find($id);

        if (is_null($container)) {
            return response()->json(['title' => __('DawnstarLang::general.swal.error.title'), 'subtitle' => __('DawnstarLang::general.swal.error.subtitle')], 406);
        }

        $container->delete();

        // Admin Action
        addAction($container, 'delete');

        return response()->json(['title' => __('DawnstarLang::general.swal.success.title'), 'subtitle' => __('DawnstarLang::general.swal.success.subtitle')]);
    }

    public function getUrl(Request $request)
    {
        $languageId = $request->get('language_id');
        $containerSlug = $request->get('url');

        $language = Language::find($languageId);

        $url = '/' . $language->code . $containerSlug;

        $urlExist = Url::where('url', $url)->exists();

        if ($urlExist) {
            return $this->getNewSlug($language->code, $containerSlug, 1);
        }
        return $containerSlug;
    }

    private function getNewSlug($languageCode, $containerSlug, $counter)
    {
        $url = '/' . $languageCode . $containerSlug . '-' . $counter;

        $urlExist = Url::where('url', $url)->exists();

        if ($urlExist) {
            return $this->getNewSlug($languageCode, $containerSlug, ++$counter);
        }
        return $containerSlug . '-' . $counter;
    }
}
