<?php

namespace Dawnstar\Core\Http\Controllers;

use Dawnstar\Core\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Hash;

class ProfileController extends BaseController
{
    public function index()
    {
        $admin = auth()->user();

        return view('Core::modules.profile.index', compact('admin'));
    }

    public function update(ProfileRequest $request)
    {
        $data = $request->only(['first_name', 'last_name', 'password']);
        $medias = $request->get('medias');

        if ($data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $admin = auth()->user();
        $admin->update($data);
        $admin->syncMedias($medias);

        return to_route('dawnstar.profile.index')->with(['success' => __('Core::admin.success.profile_update')]);
    }
}
