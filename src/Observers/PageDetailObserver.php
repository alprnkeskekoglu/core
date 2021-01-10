<?php

namespace Dawnstar\Observers;

use Dawnstar\Models\ContainerDetail;
use Dawnstar\Models\PageDetail;
use Dawnstar\Models\Url;

class PageDetailObserver
{
    public function created(PageDetail $detail)
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

    public function saved(PageDetail $detail)
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
