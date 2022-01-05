<?php

namespace Dawnstar\Core\Traits;

use Dawnstar\Core\Models\Language;

trait HasTranslation
{
    public function translation()
    {
        $model = $this;
        $languageClass = get_class($model) . 'Translation';
        $languageClassTable = (new $languageClass)->getTable();

        $languages = $this->getLanguageArray();

        $orderStr = "case";
        $counter=0;
        $languageOrderValues = [];
        foreach($languages as $language){
            $orderStr.=" when `$languageClassTable`.`language_id`=? then ".++$counter;
            $languageOrderValues[]=$language;
        }
        $orderStr.=" else ".++$counter." end";

        return $this->hasOne($languageClass)->orderByRaw($orderStr, $languageOrderValues);
    }

    private function getLanguageArray()
    {
        $request = request();
        $pathInfo = $request->getPathInfo();

        $languages = $this->translations()->pluck('language_id')->toArray();

        if(strpos($pathInfo, '/dawnstar') > -1) {
            $defaultLanguage = session('dawnstar.language');
        } else {
            $defaultLanguage = dawnstar()->language;
        }

        $return = [];
        if($defaultLanguage) {
            $return[] = $defaultLanguage->id;
        }

        return array_unique(array_merge($return, $languages));
    }
}
