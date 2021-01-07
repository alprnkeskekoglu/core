<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Http\Requests\AdminRequest;
use Dawnstar\Models\Admin;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends BaseController
{
    public function index()
    {
        $admins = Admin::all();
        $breadcrumb = [
            [
                'name' => __('DawnstarLang::admin.index_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.admin.index', compact('admins', 'breadcrumb'));
    }

    public function create()
    {
        $breadcrumb = [
            [
                'name' => __('DawnstarLang::admin.index_title'),
                'url' => route('dawnstar.admin.index')
            ],
            [
                'name' => __('DawnstarLang::admin.create_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.admin.create', compact('breadcrumb'));
    }

    public function store(AdminRequest $request)
    {
        $data = $request->except('_token');

        $request->validated();
        $data['password'] = Hash::make($data['password']);

        $admin = Admin::firstOrCreate($data);

        // Admin Action
        addAction($admin, 'store');

        return redirect()->route('dawnstar.admin.index')->with('success_message', __('DawnstarLang::admin.response_message.store'));
    }

    public function edit(int $id)
    {
        $admin = Admin::find($id);

        if (is_null($admin)) {
            return redirect()->route('dawnstar.admin.index')->withErrors(__('DawnstarLang::admin.response_message.id_error', ['id' => $id]))->withInput();
        }

        $breadcrumb = [
            [
                'name' => __('DawnstarLang::admin.index_title'),
                'url' => route('dawnstar.admin.index')
            ],
            [
                'name' => __('DawnstarLang::admin.edit_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.admin.edit', compact('admin', 'breadcrumb'));
    }

    public function update(AdminRequest $request, $id)
    {
        $admin = Admin::find($id);

        if (is_null($admin)) {
            return redirect()->route('dawnstar.admin.index')->withErrors(__('DawnstarLang::admin.response_message.id_error', ['id' => $id]))->withInput();
        }

        $data = $request->except('_token');

        $request->validated();

        if(is_null($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $admin->update($data);

        // Admin Action
        addAction($admin, 'update');

        return redirect()->route('dawnstar.admin.index')->with('success_message', __('DawnstarLang::admin.response_message.update'));
    }

    public function delete($id)
    {
        $admin = Admin::find($id);

        if (!is_null($admin) || auth('admin')->id() == $id) {
            return response()->json(['title' => __('DawnstarLang::general.swal.error.title'), 'subtitle' => __('DawnstarLang::general.swal.error.subtitle')], 406);
        }

        $admin->delete();

        // Admin Action
        addAction($admin, 'delete');

        return response()->json(['title' => __('DawnstarLang::general.swal.success.title'), 'subtitle' => __('DawnstarLang::general.swal.success.subtitle')]);
    }
}
