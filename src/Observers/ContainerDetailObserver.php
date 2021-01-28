<?php

namespace Dawnstar\Observers;

use Dawnstar\Models\CategoryDetail;
use Dawnstar\Models\ContainerDetail;
use Dawnstar\Models\PageDetail;
use Dawnstar\Models\Url;
use Illuminate\Support\Facades\DB;

class ContainerDetailObserver
{
    public function created(ContainerDetail $detail)
    {
        $language = $detail->language;
        $urlText = '/' . $language->code . $detail->slug;

        $detail->url()->create(
            [
                'type' => 'original',
                'url' =>  $urlText
            ]
        );
    }

    public function saved(ContainerDetail $detail)
    {
        $language = $detail->language;

        $url = $detail->url;
        $urlText = '/' . $language->code . $detail->slug;

        $oldUrl = $url->url;

        $url->update([
            'url' =>  $urlText
        ]);

        Url::whereHasMorph('model', [PageDetail::class, CategoryDetail::class], function ($query) use($detail) {
            $query->whereHas('parent', function ($q) use($detail) {
                $q->where('container_id', $detail->container_id);
            });
        })->update(['url' => DB::raw("REPLACE(url, '$oldUrl', '$urlText')")]);
    }

    public function deleted(ContainerDetail $detail)
    {
        $detail->url()->delete();
        $detail->extras()->delete();
    }
}
