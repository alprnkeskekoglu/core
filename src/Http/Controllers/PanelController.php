<?php

namespace Dawnstar\Http\Controllers;

use Dawnstar\Models\Language;

class PanelController extends BaseController
{
    public function changeLanguage(Language $language)
    {
        session(['dawnstar.language' => $language]);
        app()->setLocale(session('dawnstar.language.code', 'tr'));

        return back();
    }
}
