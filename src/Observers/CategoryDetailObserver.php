<?php

namespace Dawnstar\Observers;

use Dawnstar\Models\CategoryDetail;
use Dawnstar\Models\Url;

class CategoryDetailObserver
{
    public function created(CategoryDetail $detail)
    {
        if($detail && $detail->slug) {
            $language = $detail->language;

            $url = $detail->url;

            $modelId = $detail->id;
            $modelClass = get_class($detail);
            $type = 'original';
            $urlText = '/' . $language->code . $detail->slug;

            $url->update([
                'url' =>  $urlText
            ]);
        }
    }

    public function saved(CategoryDetail $detail)
    {
        if($detail && $detail->slug) {
            $language = $detail->language;

            $url = $detail->url;

            $modelId = $detail->id;
            $modelClass = get_class($detail);
            $type = 'original';
            $urlText = '/' . $language->code . $detail->slug;

            $url->update([
                'url' =>  $urlText
            ]);
        }
    }

}
