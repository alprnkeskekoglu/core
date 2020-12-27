<?php

namespace Dawnstar\Http\Controllers;

use App\Http\Controllers\Controller;
use Analytics;
use Spatie\Analytics\Period;

class DashboardController extends Controller
{
    public function index()
    {
        return view('DawnstarView::pages.dashboard');
    }
}
