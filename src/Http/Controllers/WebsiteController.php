<?php

namespace Dawnstar\Core\Http\Controllers;

use Database\Seeders\DatabaseSeeder;
use Dawnstar\Core\Database\seeds\LanguageSeeder;
use Dawnstar\Core\Http\Requests\WebsiteRequest;
use Dawnstar\Core\Models\Website;
use Dawnstar\Core\Models\Language;

class WebsiteController extends BaseController
{
    public function index()
    {
        canUser("index");

        $websites = Website::all();
        return view('Core::modules.website.index', compact('websites'));
    }

    public function create()
    {
        canUser("create");

        $languages = Language::all();
        return view('Core::modules.website.create', compact('languages'));
    }

    public function store(WebsiteRequest $request)
    {
        canUser("create");

        $data = $request->only(['status', 'default', 'name', 'domain']);
        $languages = $request->get('languages');
        $defaultLanguage = $request->get('default_language');

        $website = Website::create($data);

        if($data['default'] == 1) {
            Website::where('default', 1)->where('id', $website->id)->update(['default' => 0]);
        }

        $website->languages()->sync($languages);
        $website->languages()->updateExistingPivot($defaultLanguage, ['default' => 1]);

        if(session('dawmstar.website') == null) {
            $this->setSession($website);
        }

        return redirect()->route('dawnstar.websites.index')->with(['success' => __('Core::website.success.store')]);
    }


    public function edit(Website $website)
    {
        canUser("edit");

        $selectedLanguages = $website->languages;
        $languages = Language::all();

        return view('Core::modules.website.edit', compact('website', 'languages', 'selectedLanguages'));
    }

    public function update(Website $website, WebsiteRequest $request)
    {
        canUser("edit");

        $data = $request->only(['status', 'default', 'name', 'domain']);
        $languages = $request->get('languages');
        $defaultLanguage = $request->get('default_language');

        $website->update($data);
        $website->languages()->sync($languages);
        $website->languages()->updateExistingPivot($defaultLanguage, ['default' => 1]);

        if($data['default'] == 1) {
            $defaultWebsites = Website::where('default', 1)->where('id', '<>', $website->id)->update(['default' => 0]);
        }

        if($website->id === session('dawnstar.website.id')) {
            $this->setSession($website);
        }

        return redirect()->route('dawnstar.websites.index')->with(['success' => __('Core::website.success.update')]);
    }

    public function destroy(Website $website)
    {
        canUser("destroy");

        $website->delete();

        return redirect()->route('dawnstar.websites.index')->with(['success' => __('Core::website.success.destroy')]);
    }

    private function setSession(Website $website)
    {
        $languages = $website->languages;
        $language = $website->languages()->wherePivot('default', 1)->first();
        session([
            'dawnstar' => [
                'website' => $website,
                'languages' => $languages,
                'language' => $language,
            ]
        ]);
    }
}
