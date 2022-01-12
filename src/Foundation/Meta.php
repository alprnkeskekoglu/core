<?php

namespace Dawnstar\Core\Foundation;

class Meta
{
    /**
     * @return mixed
     */
    public function getMetas()
    {
        return dawnstar()->url->metas;
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        $metas = $this->getMetas();

        $html = '';

        $html .= $this->getRobots() . "\n";

        if($metas->isNotEmpty()) {
            $html .= $this->getMetaHtml($metas);
        } else {
            $html .= $this->getDefaultMetaHtml();
        }

        $html .= $this->getCanonical();
        $html .= $this->getAlternateLanguage();

        return $html;
    }

    /**
     * @param $metas
     * @return string
     */
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

    /**
     * @return string
     */
    private function getDefaultMetaHtml()
    {
        $keys = ['title', 'description', 'og:title', 'og:description'];

        $html = '';
        foreach ($keys as $key) {
            $value = $this->getMetaValue($key);
            $template = $this->getMetaTemplate($key);

            if($value) {
                $html .= str_replace(['{0}', '{1}'], [$key, $value], $template) . "\n";
            }
        }

        return $html;
    }

    /**
     * @param $key
     * @param null $meta
     * @return mixed
     */
    private function getMetaValue($key, $meta = null)
    {
        if($meta && $meta->value) {
            return $meta->value;
        } else {
            if(in_array($key, ['title', 'og:title'])) {
                return dawnstar()->translation->name;
            } elseif(in_array($key, ['description', 'og:description'])) {
                return \Str::limit(strip_tags(dawnstar()->translation->detail), 150);
            }
        }
    }

    /**
     * @param string $key
     * @return string
     */
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

    /**
     * @return string
     */
    private function getRobots()
    {
        $content = dawnstar()->translation->status == 1 ? 'index, follow' : 'noindex';

        return '<meta name="robots" content="' . $content . '">';
    }

    /**
     * @return string
     */
    private function getCanonical()
    {
        return '<link rel="canonical" href="' . url(dawnstar()->url->url) . '"/>';
    }

    /**
     * @return string
     */
    private function getAlternateLanguage()
    {
        $translations = dawnstar()->parent->translations;

        $return = '';
        foreach ($translations as $translation) {
            if($translation->url) {
                $return .= "\n".'<link rel="alternate" hreflang="'.$translation->language->code.'" href="'.url($translation->url->url).'">';
            }
        }
        return $return;
    }
}
