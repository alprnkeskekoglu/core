<?php

namespace Dawnstar\Observers;

use Dawnstar\Models\CategoryDetail;
use Dawnstar\Models\Url;

class CategoryDetailObserver
{
    public function created(CategoryDetail $detail)
    {
        if($detail && $detail->slug) {
            $container = $detail->category->container;
            $containerDetail = $container->details()->where('language_id', $detail->language_id)->first();

            $urlText = $containerDetail->url->url . $detail->slug;

            $detail->url()->create(
                [
                    'website_id' => session('dawnstar.website.id'),
                    'type' => 'original',
                    'url' =>  $urlText
                ]
            );
        }
    }

    public function saved(CategoryDetail $detail)
    {
        if($detail && $detail->slug) {
            $url = $detail->url;

            $container = $detail->category->container;
            $containerDetail = $container->details()->where('language_id', $detail->language_id)->first();

            $urlText = $containerDetail->url->url . $detail->slug;

            $url->update([
                'url' =>  $urlText
            ]);
        }
    }

}
