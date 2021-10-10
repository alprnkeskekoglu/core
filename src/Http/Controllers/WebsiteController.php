<?php

namespace Dawnstar\Http\Controllers;

use Database\Seeders\DatabaseSeeder;
use Dawnstar\Database\seeds\LanguageSeeder;
use Dawnstar\Http\Requests\WebsiteRequest;
use Dawnstar\Models\Website;
use Dawnstar\Models\Language;

class WebsiteController extends BaseController
{
    public function index()
    {
        /*$seeder = new DatabaseSeeder();
        $seeder->call([
            LanguageSeeder::class
        ]);*/
        $websites = Website::paginate(12);
        return view('Dawnstar::modules.website.index', compact('websites'));
    }

    public function create()
    {
        $languages = Language::all();
        return view('Dawnstar::modules.website.create', compact('languages'));
    }

    public function store(WebsiteRequest $request)
    {
        $data = $request->only(['status', 'default', 'name', 'domain']);
        $languages = $request->get('languages');
        $defaultLanguage = $request->get('default_language');

        $website = Website::create($data);
        $website->languages()->sync($languages);
        $website->languages()->updateExistingPivot($defaultLanguage, ['is_default' => 1]);

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
        $website->languages()->updateExistingPivot($defaultLanguage, ['is_default' => 1]);

        if($data['default'] == 1) {
            $defaultWebsites = Website::where('default', 1)->where('id', '<>', $website->id)->update(['default' => 0]);
        }

        return redirect()->route('dawnstar.websites.index')->with(['success' => __('Dawnstar::website.success.update')]);
    }

    public function destroy(Website $website)
    {
        $website->delete();
        return redirect()->route('dawnstar.websites.index')->with(['success' => __('Dawnstar::website.success.destroy')]);
    }
}
