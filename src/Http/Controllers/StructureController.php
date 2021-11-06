<?php

namespace Dawnstar\Http\Controllers;

class StructureController extends BaseController
{
    public function index()
    {
        $websites = Website::all();
        return view('Dawnstar::modules.website.index', compact('websites'));
    }

    public function create()
    {
        $languages = session('dawnstar.languages');
        return view('Dawnstar::modules.structure.create', compact('languages'));
    }

    public function store(WebsiteRequest $request)
    {
        $data = $request->only(['status', 'default', 'name', 'domain']);
        $languages = $request->get('languages');
        $defaultLanguage = $request->get('default_language');

        $website = Website::create($data);
        $website->languages()->sync($languages);
        $website->languages()->updateExistingPivot($defaultLanguage, ['default' => 1]);

        if($data['default'] == 1) {
            $defaultWebsites = Website::where('default', 1)->where('id', $website->id)->update(['default' => 0]);
        }

        return redirect()->route('dawnstar.websites.index')->with(['success' => __('Dawnstar::website.success.store')]);
    }


    public function edit(Website $website)
    {
        $selectedLanguages = $website->languages;
        $languages = Language::all();

        return view('Dawnstar::modules.website.edit', compact('website', 'languages', 'selectedLanguages'));
    }

    public function update(Website $website, WebsiteRequest $request)
    {
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

        return redirect()->route('dawnstar.websites.index')->with(['success' => __('Dawnstar::website.success.update')]);
    }

    public function destroy(Website $website)
    {
        $website->delete();

        return redirect()->route('dawnstar.websites.index')->with(['success' => __('Dawnstar::website.success.destroy')]);
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
