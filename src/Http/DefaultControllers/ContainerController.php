<?php

namespace App\Http\Controllers\Website1;

use App\Http\Controllers\Controller;
use Dawnstar\Foundation\Dawnstar;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function containerPage(Dawnstar $dawnstar)
    {
        return view('pages.homepage.container');
    }
}
