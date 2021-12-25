<?php

namespace Dawnstar\Core\Http\Controllers;

use Dawnstar\Core\Http\Requests\AdminRequest;
use Dawnstar\Core\MediaManager\Foundation\MediaUpload;
use Dawnstar\Core\MediaManager\Models\ModelMedia;
use Dawnstar\Core\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminController extends BaseController
{
    public function index()
    {
        canUser('admin.index', false);

        $admins = Admin::all();
        return view('Core::modules.admin.index', compact('admins'));
    }

    public function create()
    {
        canUser('admin.create', false);

        $roles = Role::all();
        return view('Core::modules.admin.create', compact('roles'));
    }

    public function store(AdminRequest $request)
    {
        $data = $request->only(['status', 'email', 'first_name', 'last_name', 'email', 'password']);
        $medias = $request->get('medias');
        $roleId = $request->get('role_id');

        $data['password'] = Hash::make($data['password']);

        $admin = Admin::create($data);
        $admin->syncMedias($medias);

        $role = Role::findById($roleId);
        $admin->syncRoles([$role->name]);

        return redirect()->route('dawnstar.admins.index')->with(['success' => __('Core::admin.success.store')]);
    }


    public function edit(Admin $admin)
    {
        canUser('admin.edit', false);

        $roles = Role::all();
        return view('Core::modules.admin.edit', compact('admin', 'roles'));
    }

    public function update(Admin $admin, AdminRequest $request)
    {
        $data = $request->only(['status', 'email', 'first_name', 'last_name', 'email', 'password']);
        $medias = $request->get('medias');
        $roleId = $request->get('role_id');

        if ($data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $admin->update($data);
        $admin->syncMedias($medias);

        $role = Role::findById($roleId);
        $admin->syncRoles([$role->name]);

        return redirect()->route('dawnstar.admins.index')->with(['success' => __('Core::admin.success.update')]);
    }

    public function destroy(Admin $admin)
    {
        canUser('admin.destroy', false);

        if($admin->id === auth()->id()) {
            return redirect()->route('dawnstar.admins.index')->with(['error' => __('Core::admin.error.destroy_auth_admin')]);
        }

        $admin->delete();

        return redirect()->route('dawnstar.admins.index')->with(['success' => __('Core::admin.success.destroy')]);
    }
}
