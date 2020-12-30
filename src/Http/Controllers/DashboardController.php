<?php

namespace Dawnstar\Http\Controllers;

class DashboardController extends PanelController
{
    public function index()
    {
        return view('DawnstarView::pages.dashboard');
    }
}
