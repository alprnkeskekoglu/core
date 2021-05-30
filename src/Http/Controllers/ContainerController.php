<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Contracts\Services\ModelStoreService;
use Dawnstar\Foundation\FormBuilder;
use Dawnstar\Http\Requests\ContainerRequest;
use Dawnstar\Models\Container;
use Dawnstar\Models\ContainerDetail;
use Dawnstar\Models\Language;
use Dawnstar\Models\Meta;
use Dawnstar\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ContainerController extends BaseController
{
    public function edit(int $id)
    {
        $container = Container::findOrFail($id);

        $languages = $container->languages();

        $formBuilder = new FormBuilder('container', $id);

        $breadcrumb = [];
        if ($container->type == 'dynamic') {
            $breadcrumb[] = [
                'name' => __('DawnstarLang::container.index_title'),
                'url' => route('dawnstar.containers.pages.index', ['containerId' => $id])
            ];
        }

        $breadcrumb[] = [
            'name' => __('DawnstarLang::container.edit_title'),
            'url' => '#'
        ];

        return view('DawnstarView::pages.container.edit', compact('container', 'languages', 'formBuilder', 'breadcrumb'));
    }

    public function update(Request $request, int $id)
    {
        $container = Container::findOrFail($id);

        $storeService = new ModelStoreService();

        $data = $request->except('_token');

        $details = $data['details'] ?? [];
        $medias = $data['medias'] ?? [];
        $metas = $data['metas'] ?? [];
        unset($data['details'], $data['medias'], $data['metas']);

        $storeService->update($container, $data);

        $storeService->storeDetails($container, $details);

        $storeService->storeMedias($container, $medias);

        $storeService->storeMetas($container, $metas);

        // Admin Action
        addAction($container, 'update');

        if ($container->type == 'static') {
            return redirect()->route('dawnstar.containers.edit', ['id' => $id])->with('success_message', __('DawnstarLang::container.response_message.update'));
        }

        return redirect()->route('dawnstar.containers.pages.index', ['containerId' => $id])->with('success_message', __('DawnstarLang::container.response_message.update'));
    }

    public function getUrl(Request $request)
    {
        $languageId = $request->get('language_id');
        $containerSlug = $request->get('url');
        $containerName = $request->get('name');

        $language = Language::find($languageId);

        $urlText = '/' . $language->code . $containerSlug;

        $url = Url::where('website_id', session('dawnstar.website.id'))->where('url', $urlText)->first();

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
