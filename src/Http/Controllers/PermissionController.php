<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Models\Container;
use Dawnstar\Models\Website;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends BaseController
{
    public function index(Role $role)
    {
        $breadcrumb = [
            [
                'name' => __('DawnstarLang::permission.index_title'),
                'url' => '#'
            ]
        ];

        $websites = Website::where('status', 1)->orderBy('order')->get();
        $containers = Container::where('status', 1)->get()->groupBy('website_id');

        return view('DawnstarView::pages.permission.index', compact('role', 'websites', 'containers', 'breadcrumb'));
    }

    public function store(Request $request, Role $role)
    {
        $data = $request->except('_token');

        foreach ($data['permissions'] as $permission => $value) {

            Permission::firstOrCreate(['name' => $permission]);

            if($value == 1) {
                $role->givePermissionTo($permission);
            } else {
                $role->revokePermissionTo($permission);
            }
        }

        return back();
    }
}
