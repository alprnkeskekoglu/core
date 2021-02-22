<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Contracts\Services\ModelStoreService;
use Dawnstar\Http\Requests\AdminRequest;
use Dawnstar\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends BaseController
{
    public function index()
    {
        $admin = auth('admin')->user();
        $breadcrumb = [
            [
                'name' => __('DawnstarLang::profile.index_title'),
                'url' => '#'
            ]
        ];

        return view('DawnstarView::pages.profile.index', compact('admin', 'breadcrumb'));
    }

    public function update(Request $request)
    {
        $admin = auth('admin')->user();

        $data = $request->except('_token', 'image');

        if(is_null($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $admin->update($data);

        $storeDevice = new ModelStoreService();
        $storeDevice->storeMedias($admin, ['image' => $request->get('image')]);

        auth('admin')->user()->fresh();

        // Admin Action
        addAction($admin, 'update');

        return redirect()->route('dawnstar.profiles.index')->with('success_message', __('DawnstarLang::admin.response_message.update'));
    }
}
