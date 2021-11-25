<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Models\Admin;
use Dawnstar\Models\AdminAction;

class AdminActionController extends BaseController
{
    public function index()
    {
        $admins = Admin::all();
        $actions = AdminAction::orderByDesc('id')->get();

        return view('Dawnstar::modules.admin_action.index', compact('admins', 'actions'));
    }
}
