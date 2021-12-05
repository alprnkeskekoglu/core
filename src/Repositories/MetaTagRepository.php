<?php

namespace Dawnstar\Repositories;

use Dawnstar\Contracts\MetaTagInterface;
use Dawnstar\Models\MetaTag;
use Illuminate\Support\Facades\Schema;

class MetaTagRepository implements MetaTagInterface
{
    public function sync($translation, $data)
    {
        $url = $translation->url;
        $data = $data[$translation->language_id];

        if ($url) {
            foreach ($data as $key => $value) {
                MetaTag::updateOrCreate(
                    [
                        'url_id' => $url->id,
                        'key' => $key
                    ],
                    [
                        'template' => $this->getTemplate($key),
                        'value' => $value,
                    ]
                );
            }
        }
    }

    private function getTemplate(string $key)
    {
        if ($key == 'title') {
            return '<{0}>{1}</{0}>';
        } elseif (\Str::startsWith($key, 'og:')) {
            return '<meta property="{0}" content="{1}">';
        } else {
            return '<meta name="{0}" content="{1}">';
        }
    }
}
