<?php

namespace Dawnstar\Http\Controllers;

use Database\Seeders\DatabaseSeeder;
use Dawnstar\Database\seeds\LanguageSeeder;
use Dawnstar\Dawnstar\Models\Website;
use Illuminate\Http\Request;

class WebsiteController extends BaseController
{
    public function index()
    {
        $seeder = new DatabaseSeeder();
        $seeder->call([
            LanguageSeeder::class
        ]);
        return view('Dawnstar::modules.website.index');
    }

    public function create()
    {
        return view('Dawnstar::modules.website.create');
    }

    public function store(Request $request)
    {
        //
    }


    public function edit(Website $website)
    {
        //
    }

    public function update(Website $website, Request $request)
    {
        //
    }

    public function destroy(Website $website)
    {
        //
    }
}
