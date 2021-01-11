<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Models\CustomContent;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class CustomContentController extends BaseController
{
    public function index()
    {
        $customContents = $this->getCustomContents();

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::custom_content.index_title'),
                'url' => '#'
            ],
        ];

        return view('DawnstarView::pages.custom_content.index', compact('customContents', 'breadcrumb'));
    }

    public function search(Request $request)
    {
        $search = $request->get('search');

        $customContents = $this->getCustomContents($search);

        return view('DawnstarView::pages.custom_content.ajax', compact('customContents'))->render();
    }

    public function update(Request $request)
    {
        $languageId = $request->get('language_id');
        $key = $request->get('key');
        $value = $request->get('value');

        $customContent = CustomContent::where('key', $key)->where('language_id', $languageId)->first();

        if (is_null($customContent)) {
            throw new \Exception();
        }

        $customContent->update(['value' => $value]);

        // Admin Action
        addAction($customContent, 'update');
    }

    private function getCustomContents(string $search = null)
    {
        $customContents = CustomContent::where('website_id', session('dawnstar.website.id'));

        if ($search) {
            $customContents = $customContents->where(function ($q) use ($search) {
                $q->where('key', 'like', '%' . $search . '%')
                    ->orWhere('value', 'like', '%' . $search . '%');
            });
        }

        $customContents = $customContents->get()->groupBy('key');

        $return = [];
        $defaultLanguageId = 760;
        foreach ($customContents as $key => $content) {
            $default = $content->where('langauge_id', $defaultLanguageId)->first();

            $return[$key]['default_value'] = $default ? $default->value : $content->first()->value;

            foreach ($content as $cont) {
                $return[$key]['languages'][$cont->language_id] = [
                    'language_name' => $cont->language->native_name,
                    'language_code' => $cont->language->code,
                    'value' => $cont->value
                ];
            }
        }

        return $return;
    }


    private function getBreadcrumb(array $parameters)
    {
        $breadcrumb = [];

        foreach ($parameters as $param) {
            $breadcrumb[] = [
                'name' => __('DawnstarLang::form.' . $param[0] . '_title'),
                'url' => route('dawnstar.form.' . $param[1] ?? '', $param[2] ?? [])
            ];
        }

        return $breadcrumb;
    }
}
