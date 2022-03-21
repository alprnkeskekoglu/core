<?php

namespace Dawnstar\Core\Http\Controllers;

use Dawnstar\Core\Models\CategoryTranslation;
use Dawnstar\Core\Models\Container;
use Dawnstar\Core\Models\ContainerTranslation;
use Dawnstar\Core\Models\Language;
use Dawnstar\Core\Models\PageTranslation;
use Dawnstar\Core\Models\Structure;
use Dawnstar\Core\Models\Url;
use Dawnstar\Core\Models\Website;
use Dawnstar\Core\Services\DawnstarService;
use Dawnstar\Tracker\Foundation\Tracker;
use Illuminate\Support\Facades\Hash;

class WebController extends BaseController
{
    public function __construct(protected DawnstarService $dawnstarService)
    {
    }

    public function index()
    {
        return $this->dawnstarService->init();
    }
}
