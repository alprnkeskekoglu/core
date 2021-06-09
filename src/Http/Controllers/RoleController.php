<?php

namespace Dawnstar\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends BaseController
{
    public function index()
    {
        $roles = Role::all();
        $breadcrumb = [
            [
                'name' => __('DawnstarLang::role.index_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.role.index', compact('roles', 'breadcrumb'));
    }

    public function create()
    {
        $breadcrumb = [
            [
                'name' => __('DawnstarLang::role.index_title'),
                'url' => route('dawnstar.roles.index')
            ],
            [
                'name' => __('DawnstarLang::role.create_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.role.create', compact('breadcrumb'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');


        $role = Role::firstOrCreate($data);

        // Admin Action
        addAction($role, 'store');

        return redirect()->route('dawnstar.roles.index')->with('success_message', __('DawnstarLang::role.response_message.store'));
    }

    public function edit(Role $role)
    {
        if ($role->id == 1) {
            return redirect()->route('dawnstar.roles.index');
        }

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::role.index_title'),
                'url' => route('dawnstar.roles.index')
            ],
            [
                'name' => __('DawnstarLang::role.edit_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.role.edit', compact('role', 'breadcrumb'));
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->except('_token');

        $admin->update($data);

        // Admin Action
        addAction($role, 'update');

        return redirect()->route('dawnstar.roles.index')->with('success_message', __('DawnstarLang::role.response_message.update'));
    }

    public function destroy(Role $role)
    {
        if ($role->id == 1) {
            return response()->json(['title' => __('DawnstarLang::general.swal.error.title'), 'subtitle' => __('DawnstarLang::general.swal.error.subtitle')], 406);
        }

        $role->delete();

        // Admin Action
        addAction($role, 'delete');

        return response()->json(['title' => __('DawnstarLang::general.swal.success.title'), 'subtitle' => __('DawnstarLang::general.swal.success.subtitle')]);
    }
}
