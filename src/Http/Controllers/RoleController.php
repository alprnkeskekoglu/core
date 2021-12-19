<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Models\Website;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends BaseController
{
    public function index()
    {
        canUser("role.index", false);

        $roles = Role::all();
        return view('Dawnstar::modules.role.index', compact('roles'));
    }

    public function create()
    {
        canUser("role.create", false);

        $websites = Website::where('status', 1)->with('structures')->get();

        return view('Dawnstar::modules.role.create', compact('websites'));
    }

    public function store(Request $request)
    {
        canUser("role.create", false);

        $data = $request->only('name');
        $permissions = $request->get('permissions');

        $role = Role::firstOrCreate($data);

        foreach ($permissions as $permission => $value) {
            Permission::firstOrCreate(['name' => $permission]);

            if($value == 1) {
                $role->givePermissionTo($permission);
            } else {
                $role->revokePermissionTo($permission);
            }
        }

        adminAction($role, 'store');

        return redirect()->route('dawnstar.roles.index')->with(['success' => __('Dawnstar::role.success.store')]);
    }


    public function edit(Role $role)
    {
        canUser("role.edit", false);

        if ($role->id == 1) {
            return redirect()->route('dawnstar.roles.index');
        }
        $websites = Website::where('status', 1)->with('structures')->get();
        $permissions = $role->getAllPermissions()->pluck('id','name')->toArray();

        return view('Dawnstar::modules.role.edit', compact('role', 'websites', 'permissions'));
    }

    public function update(Role $role, Request $request)
    {
        canUser("role.edit", false);

        $data = $request->only('name');
        $permissions = $request->get('permissions');

        $role->update($data);


        foreach ($permissions as $permission => $value) {
            Permission::firstOrCreate(['name' => $permission]);

            if($value == 1) {
                $role->givePermissionTo($permission);
            } else {
                $role->revokePermissionTo($permission);
            }
        }

        adminAction($role, 'update');

        return redirect()->route('dawnstar.roles.index')->with(['success' => __('Dawnstar::role.success.update')]);
    }

    public function destroy(Role $role)
    {
        canUser("role.destroy", false);

        if ($role->id == 1) {
            return redirect()->route('dawnstar.roles.index');
        }

        $role->delete();
        adminAction($role, 'destroy');

        return redirect()->route('dawnstar.roles.index')->with(['success' => __('Dawnstar::role.success.destroy')]);
    }
}
