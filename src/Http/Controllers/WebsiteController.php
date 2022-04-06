<?php

namespace Dawnstar\Core\Http\Controllers;

use Database\Seeders\DatabaseSeeder;
use Dawnstar\Core\Contracts\WebsiteInterface;
use Dawnstar\Core\Database\seeds\LanguageSeeder;
use Dawnstar\Core\Http\Requests\WebsiteRequest;
use Dawnstar\Core\Models\Website;
use Dawnstar\Core\Models\Language;
use Dawnstar\Core\Repositories\LanguageRepository;
use Dawnstar\Core\Repositories\WebsiteRepository;

class WebsiteController extends BaseController
{
    public function __construct(
        protected WebsiteRepository $websiteRepository,
        protected LanguageRepository $languageRepository
    )
    {
    }

    public function index()
    {
        canUser("index");

        $websites = $this->websiteRepository->getAll();

        return view('Core::modules.website.index', compact('websites'));
    }

    public function create()
    {
        canUser("create");

        $languages = $this->languageRepository->getAll();

        return view('Core::modules.website.create', compact('languages'));
    }

    public function store(WebsiteRequest $request)
    {
        canUser("create");

        $this->websiteRepository->store();

        return to_route('dawnstar.websites.index')->with(['success' => __('Core::website.success.store')]);
    }


    public function edit(Website $website)
    {
        canUser("edit");

        $selectedLanguages = $website->languages;
        $languages = $this->languageRepository->getAll();

        return view('Core::modules.website.edit', compact('website', 'languages', 'selectedLanguages'));
    }

    public function update(Website $website, WebsiteRequest $request)
    {
        canUser("edit");

        $this->websiteRepository->update($website);

        return to_route('dawnstar.websites.index')->with(['success' => __('Core::website.success.update')]);
    }

    public function destroy(Website $website)
    {
        canUser("destroy");

        $this->websiteRepository->destroy($website);

        return to_route('dawnstar.websites.index')->with(['success' => __('Core::website.success.destroy')]);
    }
}
