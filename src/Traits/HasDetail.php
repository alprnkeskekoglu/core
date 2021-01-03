<?php

namespace Dawnstar\Traits;

use Dawnstar\Models\Language;

trait HasDetail{
    //TODO rewrite

    public function detail()
    {
        $model = $this;
        $detailClass = $model::class . 'Detail';
        $language = $this->getLanguage();

        return $this->hasOne($detailClass)->where('language_id', $language->id);
    }

    private function getLanguage()
    {
        $request = request();
        $pathInfo = $request->getPathInfo();

        if(strpos($pathInfo, '/dawnstar/') > -1) {
            $language = session('dawnstar.language') ?: Language::where('id', 164)->first();
        } else {
            $language = Language::where('id', 164)->first();
        }

        return $language;
    }
}
