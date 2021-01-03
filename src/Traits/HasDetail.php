<?php

namespace Dawnstar\Traits;

use Dawnstar\Models\Language;

trait HasDetail{
    //TODO rewrite

    public function detail()
    {
        $model = $this;
        $detailClass = $model::class . 'Detail';
        $languages = $this->getLanguageArray();

        foreach ($languages as $languageId) {
            $relation = $this->hasOne($detailClass)->where('language_id', $languageId);

            if(is_null($relation->first())) {
                continue;
            }
            return $relation;
        }

        return $this->hasOne($detailClass)->where('language_id', $languageId)->withDefault();
    }

    private function getLanguageArray()
    {
        $request = request();
        $pathInfo = $request->getPathInfo();

        if(strpos($pathInfo, '/dawnstar/') > -1) {
            $languages = $this->details()->pluck('language_id')->toArray();
            $defaultLanguage = session('dawnstar.language');

            $return = [];

            if($defaultLanguage) {
                $return[] = $defaultLanguage->id;
            }

            $return = array_merge($return, $languages);

        } else {
            $language = Language::where('id', 164)->first();
        }

        return $return;
    }
}
