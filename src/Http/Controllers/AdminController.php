<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Http\Requests\AdminRequest;
use Dawnstar\MediaManager\Foundation\MediaUpload;
use Dawnstar\MediaManager\Models\ModelMedia;
use Dawnstar\Models\Admin;

class AdminController extends BaseController
{
    public function index()
    {
        $admins = Admin::all();
        return view('Dawnstar::modules.admin.index', compact('admins'));
    }

    public function create()
    {
        $roles = [];
        return view('Dawnstar::modules.admin.create', compact('roles'));
    }

    public function store(AdminRequest $request)
    {
        $data = $request->only(['status', 'emai', 'first_name', 'last_name', 'email', 'password']);
        $medias = $request->get('medias');
        $role_id = $request->get('role_id'); // TODO: role structure


        $admin = Admin::create($data);
        $admin->syncMedias($medias);

        return redirect()->route('dawnstar.admins.index')->with(['success' => __('Dawnstar::admin.success.store')]);
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
