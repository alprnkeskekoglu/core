<?php

namespace Dawnstar\Core\Http\Controllers;

use Dawnstar\Core\Models\Admin;
use Dawnstar\Core\Models\AdminAction;

class AdminActionController extends BaseController
{
    public function index()
    {
        $admins = Admin::all();
        $actions = AdminAction::orderByDesc('id')->get();

        return view('Core::modules.admin_action.index', compact('admins', 'actions'));
    }
}
