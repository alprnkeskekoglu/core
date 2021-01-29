<?php

namespace Dawnstar\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Artisan;

class ToolController extends BaseController
{
    private $whiteList = [
        'cacheClear', 'viewClear', 'configClear'
    ];

    public function index()
    {
        $breadcrumb = [
            [
                'name' => __('DawnstarLang::tool.index_title'),
                'url' => '#'
            ],
        ];

        return view('DawnstarView::pages.tool.index', compact('breadcrumb'));
    }

    public function init(Request $request)
    {
        $function = $request->get('function');

        if(!in_array($function, $this->whiteList)) {
            return response()->json(['title' => __('DawnstarLang::tool.swal.error.title'), 'subtitle' => __('DawnstarLang::tool.swal.error.subtitle')], 406);
        }

        return $this->{$function}();
    }

    private function cacheClear()
    {
        Artisan::call('cache:clear');

        return response()->json(['title' => __('DawnstarLang::tool.swal.success.title'), 'subtitle' => Artisan::output()]);
    }

    private function viewClear()
    {
        Artisan::call('view:clear');

        return response()->json(['title' => __('DawnstarLang::tool.swal.success.title'), 'subtitle' => Artisan::output()]);
    }

    private function configClear()
    {
        Artisan::call('config:clear');

        return response()->json(['title' => __('DawnstarLang::tool.swal.success.title'), 'subtitle' => Artisan::output()]);
    }

}
