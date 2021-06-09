<?php

namespace Dawnstar\Http\Controllers;

class DashboardController extends BaseController
{
    public function index()
    {
        return view('DawnstarView::pages.dashboard');
    }
}
