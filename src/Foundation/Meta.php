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

        if($metas->isNotEmpty()) {
            $html .= $this->getMetaHtml($metas);
        } else {
            $html .= $this->getDefaultMetaHtml();
        }

        $html .= $this->getCanonical();

        return $html;
    }

    private function getMetaHtml($metas)
    {
        $html = '';
        foreach ($metas as $meta) {
            $key = $meta->key;
            $value = $this->getMetaValue($key, $meta);
            $template = $this->getMetaTemplate($key);

            if($value) {
                $html .= str_replace(['{0}', '{1}'], [$key, $value], $template) . "\n\t";
            }
        }

        return $html;
    }

    private function getDefaultMetaHtml()
    {
        $keys = ['title', 'description', 'og:title', 'og:description'];

        $html = '';
        foreach ($keys as $key) {
            $value = $this->getMetaValue($key);
            $template = $this->getMetaTemplate($key);

            if($value) {
                $html .= str_replace(['{0}', '{1}'], [$key, $value], $template) . "\n\t";
            }
        }

        return $html;
    }

    private function getMetaValue($key, $meta = null)
    {
        if($meta && $meta->value) {
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
