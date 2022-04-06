<?php

namespace Dawnstar\Core\Http\Controllers;

use Dawnstar\Core\Models\Language;
use Dawnstar\Core\Models\Website;
use Dawnstar\Core\Repositories\WebsiteRepository;

class PanelController extends BaseController
{
    public function __construct(
        protected WebsiteRepository $websiteRepository,
    )
    {
    }

    public function changeWebsite(Website $website)
    {
        $this->websiteRepository->setSession($website);

        return to_route('dawnstar.dashboard.index');
    }
    public function changeLanguage(Language $language)
    {
        session(['dawnstar.language' => $language]);
        app()->setLocale($language->code);

        return back();
    }
}
