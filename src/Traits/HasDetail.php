<?php

namespace Dawnstar\Traits;

use Dawnstar\Models\Language;

trait HasDetail{
    // TODO rewrite

    public function detail()
    {
        $model = $this;
        $detailClass = $model::class . 'Detail';
        $detailClassTable = (new $detailClass)->getTable();

        $languages = $this->getLanguageArray();

        $orderStr = "case";
        $counter=0;
        foreach($languages as $language){
            $orderStr.=" when `$detailClassTable`.`language_id`=? then ".++$counter;
            $languageOrderValues[]=$language;
        }
        $orderStr.=" else ".++$counter." end";

        return $this->hasOne($detailClass)->orderByRaw($orderStr, $languageOrderValues);
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

            $return = array_unique(array_merge($return, $languages));

        } else {
            // TODO: change website language
            $language = Language::where('id', 164)->first();

            return [$language->id];
        }

        return $return;
    }
}
