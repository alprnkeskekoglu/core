<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Foundation\ContainerFileKit;
use Dawnstar\Foundation\FormBuilder;
use Dawnstar\Http\Requests\ContainerRequest;
use Dawnstar\Models\Container;
use Dawnstar\Models\ContainerDetail;
use Dawnstar\Models\ContainerDetailExtra;
use Dawnstar\Models\Language;
use Dawnstar\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ContainerController extends BaseController
{
    public function structureIndex()
    {
        $containers = Container::all();

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::container.index_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.container.structure.index', compact('containers', 'breadcrumb'));
    }

    public function structureCreate()
    {
        $website = session('dawnstar.website');
        $languages = $website->languages;

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::container.index_title'),
                'url' => route('dawnstar.container.structure.index')
            ],
            [
                'name' => __('DawnstarLang::container.create_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.container.structure.create', compact('languages', 'breadcrumb'));
    }

    public function structureStore(ContainerRequest $request)
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

        return redirect()->route('dawnstar.container.structure.index')->with('success_message', __('DawnstarLang::container.response_message.store'));
    }

    public function structureEdit(int $id)
    {
        $container = Container::find($id);

        if (is_null($container)) {
            return redirect()->route('dawnstar.container.structure.index')->withErrors(__('DawnstarLang::container.response_message.id_error', ['id' => $id]))->withInput();
        }
        $website = session('dawnstar.website');
        $languages = $website->languages;

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::container.index_title'),
                'url' => route('dawnstar.container.structure.index')
            ],
            [
                'name' => __('DawnstarLang::container.edit_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.container.structure.edit', compact('container', 'languages', 'breadcrumb'));
    }

    public function structureUpdate(ContainerRequest $request, $id)
    {
        $container = Container::find($id);

        if (is_null($container)) {
            return redirect()->route('dawnstar.container.structure.index')->withErrors(__('DawnstarLang::container.response_message.id_error', ['id' => $id]))->withInput();
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

        return redirect()->route('dawnstar.container.structure.index')->with('success_message', __('DawnstarLang::container.response_message.update'));
    }

    public function structureDelete($id)
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

    public function edit(int $id)
    {
        $container = Container::findOrFail($id);

        $languages = $container->languages();

        $formBuilder = new FormBuilder('container', 2);

        $breadcrumb = []; // TODO

        return view('DawnstarView::pages.container.edit', compact('container', 'languages', 'formBuilder', 'breadcrumb'));
    }

    public function update(Request $request, int $id)
    {
        $container = Container::findOrFail($id);

        $data = $request->except('_token');

        $details = $data['details'] ?? [];
        unset($data['details']);

        $container->update($data);


        foreach ($details as $languageId => $detail) {

            $extras = $detail['extras'] ?? [];
            unset($detail['extras']);

            $containerDetail = ContainerDetail::updateOrCreate(
                [
                    'container_id' => $container->id,
                    'language_id' => $languageId
                ],
                $detail
            );

            $containerDetail->extras()->delete();
            foreach ($extras as $key => $value) {
                ContainerDetailExtra::create([
                    'container_detail_id' => $containerDetail->id,
                    'key' => $key,
                    'value' => $value,
                ]);
            }
        }
        // Admin Action
        addAction($container, 'update');

        // TODO: change page index
        return redirect()->route('dawnstar.page.index', ['containerId' => $id])->with('success_message', __('DawnstarLang::container.response_message.update'));

    }

    public function getUrl(Request $request)
    {
        $languageId = $request->get('language_id');
        $containerSlug = $request->get('url');
        $containerName = $request->get('name');

        $language = Language::find($languageId);

        $urlText = '/' . $language->code . $containerSlug;

        $url = Url::where('url', $urlText)->first();

        if ($url) {
            if ($containerName == $url->model->name) {
                return $containerSlug;
            }
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
