<?php

namespace Dawnstar\Foundation;

class Meta
{
    public function getMetas()
    {
        return dawnstar()->url->metas;
    }

    public function getHtml()
    {
        $metas = $this->getMetas();

        $html = '';


        $html .= $this->getRobots() . "\n\t";

        foreach ($metas as $meta) {
            $html .= $this->getMetaHtml($meta) . "\n\t";
        }

        $html .= $this->getCanonical();

        return $html;
    }

    private function getMetaHtml($meta)
    {
        $key = $meta->key;
        $value = $this->getMetaValue($meta, $key);
        $template = $this->getMetaTemplate($key);

        return str_replace(['{0}', '{1}'], [$key, $value], $template);
    }

    private function getMetaValue($meta, $key)
    {
        if($meta->value) {
            return $meta->value;
        } else {
            if(in_array($key, ['title', 'og:title'])) {
                return dawnstar()->relation->name;
            } elseif(in_array($key, ['description', 'og:description'])) {
                return strip_tags(dawnstar()->relation->detail);
            }
        }
    }

    private function getMetaTemplate(string $key)
    {
        if ($key == 'title') {
            return '<{0}>{1}</{0}>';
        } elseif (\Str::startsWith($key, 'og:')) {
            return '<meta property="{0}" content="{1}">';
        } else {
            return '<meta name="{0}" content="{1}">';
        }
    }

    private function getRobots()
    {
        $content = dawnstar()->relation->status == 1 ? 'index, follow' : 'noindex';

        return '<meta name="robots" content="' . $content . '">';
    }

    private function getCanonical()
    {
        return '<link rel="canonical" href="' . url(dawnstar()->url->url) . '"/>';
    }
}
