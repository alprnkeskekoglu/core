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
        $urlText = '/' . $language->code . $detail->slug;

        Url::firstOrCreate([
            'model_id' => $modelId,
            'model_class' => $modelClass,
            'type' => $type,
            'url' => $urlText
        ]);
    }

    public function saved(ContainerDetail $detail)
    {
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

    public function deleted(ContainerDetail $detail)
    {
        $detail->url()->delete();
        $detail->extras()->delete();
    }
}
