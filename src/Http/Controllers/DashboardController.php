<?php

namespace Dawnstar\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        return view('DawnstarView::pages.dashboard');
    }
}
