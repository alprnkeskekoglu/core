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
            $container = $detail->page->container;
            $containerDetail = $container->details()->where('language_id', $detail->language_id)->first();

            $urlText = $containerDetail->url->url . $detail->slug;

            $detail->url()->create(
                [
                    'type' => 'original',
                    'url' =>  $urlText
                ]
            );
        }
    }

    public function saved(PageDetail $detail)
    {
        if($detail && $detail->slug) {
            $url = $detail->url;

            $container = $detail->page->container;
            $containerDetail = $container->details()->where('language_id', $detail->language_id)->first();

            $urlText = $containerDetail->url->url . $detail->slug;

            $url->update([
                'url' =>  $urlText
            ]);
        }
    }

    public function deleted(ContainerDetail $detail)
    {
        $detail->url()->delete();
        $detail->extras()->delete();
    }
}
