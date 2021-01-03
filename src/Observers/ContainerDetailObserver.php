<?php

namespace Dawnstar\Observers;


use Dawnstar\Models\ContainerDetail;
use Dawnstar\Models\Url;

class ContainerDetailObserver
{
    public function created(ContainerDetail $detail)
    {
        $language = $detail->language;

        $modelId = $detail->id;
        $modelClass = get_class($detail);
        $type = 'original';
        $url = '/' . $language->code . $detail->slug;

        Url::firstOrCreate([
            'model_id' => $modelId,
            'model_class' => $modelClass,
            'type' => $type,
            'url' => $url
        ]);
    }

}
