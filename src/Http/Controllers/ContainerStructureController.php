<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Contracts\Services\ModelStoreService;
use Dawnstar\Foundation\ContainerKit;
use Dawnstar\Foundation\FormBuilder;
use Dawnstar\Http\Requests\ContainerRequest;
use Dawnstar\Models\Container;
use Dawnstar\Models\ContainerDetail;
use Dawnstar\Models\Language;
use Dawnstar\Models\Meta;
use Dawnstar\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ContainerStructureController extends BaseController
{
    public function index()
    {
        canUser("container_structure.index");

        $containers = Container::where('website_id', session('dawnstar.website.id'))->get();

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::container.index_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.container.structure.index', compact('containers', 'breadcrumb'));
    }

    public function create()
    {
        if(env('APP_ENV') != 'local') {
            return redirect()->route('dawnstar.dashboard');
        }

        $website = session('dawnstar.website');
        $languages = $website->languages;

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::container.index_title'),
                'url' => route('dawnstar.containers.structures.index')
            ],
            [
                'name' => __('DawnstarLang::container.create_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.container.structure.create', compact('languages', 'breadcrumb'));
    }

    public function store(ContainerRequest $request)
    {
        if(env('APP_ENV') != 'local') {
            return redirect()->route('dawnstar.dashboard');
        }

        $data = $request->except('_token', 'feature');

        $data['admin_id'] = $data['admin_id'] ?? auth('admin')->id();
        $data['website_id'] = session('dawnstar.website.id');
        $data['key'] = strtolower(str_replace(' ', '', $data['key']));

        $details = $data['details'];

        unset($data['details']);
        $container = Container::firstOrCreate($data);

        foreach ($details as $languageId => $detail) {
            if (!isset($detail['name'])) {
                continue;
            }

            $detail['slug'] = $detail['slug'] != '/' ? rtrim($detail['slug'], '/') : $detail['slug'];

            ContainerDetail::firstOrCreate([
                'container_id' => $container->id,
                'language_id' => $languageId,
                'status' => $detail['status'],
                'name' => $detail['name'],
                'slug' => $detail['slug'],
            ]);

        }

        $kit = new ContainerKit($container);
        $kit->createFiles();
        $kit->createBuilders();

        Cache::flush();

        // Admin Action
        addAction($container, 'store');

        return redirect()->route('dawnstar.containers.structures.index')->with('success_message', __('DawnstarLang::container.response_message.store'));
    }

    public function edit(Container $container)
    {
        canUser("container_structure.edit");

        $website = session('dawnstar.website');
        $languages = $website->languages;

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::container.index_title'),
                'url' => route('dawnstar.containers.structures.index')
            ],
            [
                'name' => __('DawnstarLang::container.edit_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.container.structure.edit', compact('container', 'languages', 'breadcrumb'));
    }

    public function update(ContainerRequest $request, Container $container)
    {
        canUser("container_structure.edit");

        $data = $request->except('_token');

        $details = $data['details'];

        unset($data['details']);
        $container->update($data);

        foreach ($details as $languageId => $detail) {
            if (!isset($detail['name'])) {
                continue;
            }
            $detail['slug'] = $detail['slug'] != '/' ? rtrim($detail['slug'], '/') : $detail['slug'];
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

        Cache::flush();

        // Admin Action
        addAction($container, 'update');

        return redirect()->route('dawnstar.containers.structures.index')->with('success_message', __('DawnstarLang::container.response_message.update'));
    }

    public function destroy(Container $container)
    {
        canUser("container_structure.destroy");

        $container->delete();

        // Admin Action
        addAction($container, 'delete');

        return redirect()->route('dawnstar.containers.structures.index')->with('success_message', __('DawnstarLang::container.response_message.destroy'));
    }
}
