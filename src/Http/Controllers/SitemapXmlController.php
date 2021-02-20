<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Artisan;

class SitemapXmlController extends BaseController
{
    public function index()
    {
        $urls = $this->getUrlArray();
        return view('DawnstarView::pages.tool.index');
    }

    private function getUrlArray()
    {
        $urlArray = [];

        $urls = Url::whereHas('model', function ($query) {
            $query->where('status', 1)
                ->whereHas('parent', function ($que) {
                    $que->where('status', 1);
                });
        })
            ->where('type', 'original')
            ->get();

        dd($urls);
    }

}
