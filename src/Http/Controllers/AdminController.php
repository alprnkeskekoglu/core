<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Http\Requests\AdminRequest;
use Dawnstar\MediaManager\Foundation\MediaUpload;
use Dawnstar\MediaManager\Models\ModelMedia;
use Dawnstar\Models\Admin;
use Illuminate\Support\Facades\Hash;

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
        $data = $request->only(['status', 'email', 'first_name', 'last_name', 'email', 'password']);
        $medias = $request->get('medias');
        $role_id = $request->get('role_id'); // TODO: role structure


        $admin = Admin::create($data);
        $admin->syncMedias($medias);

        return redirect()->route('dawnstar.admins.index')->with(['success' => __('Dawnstar::admin.success.store')]);
    }


    public function edit(Admin $admin)
    {
        $roles = [];
        return view('Dawnstar::modules.admin.edit', compact('admin', 'roles'));
    }

    public function update(Admin $admin, AdminRequest $request)
    {
        $data = $request->only(['status', 'email', 'first_name', 'last_name', 'email', 'password']);
        $medias = $request->get('medias');
        $role_id = $request->get('role_id'); // TODO: role structure

        if ($data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $admin->update($data);
        $admin->syncMedias($medias);

        return redirect()->route('dawnstar.admins.index')->with(['success' => __('Dawnstar::admin.success.update')]);
    }

    public function destroy(Admin $admin)
    {
        if($admin->id === auth()->id()) {
            return redirect()->route('dawnstar.admins.index')->with(['error' => __('Dawnstar::admin.error.destroy_auth_admin')]);
        }

        $admin->delete();
        return redirect()->route('dawnstar.admins.index')->with(['success' => __('Dawnstar::admin.success.destroy')]);
    }
}
