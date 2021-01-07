<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class PanelController extends BaseController
{
    public function changeLanguage(string $languageCode)
    {
        $language = Language::where('code', $languageCode)->first();

        session(['dawnstar.language' => $language]);

        return redirect()->back();
    }

}
