<?php

namespace Dawnstar\Core\Services;

use Illuminate\Database\Eloquent\Collection;

/**
 * Class MetaService
 * @package Dawnstar\Core\Services
 */
class MetaService
{
    /**
     * @return Collection
     */
    public function getMetas(): Collection
    {
        return dawnstar()->url ? dawnstar()->url->metas : new Collection();
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        $metas = $this->getMetas();
        $metaData = $this->getMetaData($metas);

        return $this->getMetaHtml($metaData);
    }

    /**
     * @param Collection $metas
     * @return array
     */
    private function getMetaData(Collection $metas): array
    {
        if(!isset(dawnstar()->translation)) {
            return ['title' => __('Core::errors.404')];
        }

        $metaData = $metas->pluck('value', 'key')->toArray();

        $defaultKeys = ['robots', 'title', 'description', 'og:title', 'og:description'];
        $defaultData = array_fill_keys($defaultKeys, null);

        return array_merge($defaultData, $metaData);
    }

    /**
     * @param array $metaData
     * @return string
     */
    private function getMetaHtml(array $metaData): string
    {
        $html = '';
        foreach ($metaData as $key => $value) {
            $value = $value ?: $this->getMetaValue($key);
            $template = $this->getMetaTemplate($key);

            $html .= str_replace(['{0}', '{1}'], [$key, $value], $template) . "\n";
        }

        $html .= $this->getCanonical();
        $html .= $this->getAlternateLanguage();

        return $html;
    }

    /**
     * @param string $key
     * @return string
     */
    private function getMetaValue(string $key): string
    {
        if (in_array($key, ['title', 'og:title'])) {
            return dawnstar()->translation->name;
        } elseif (in_array($key, ['description', 'og:description'])) {
            return str()->limit(strip_tags(dawnstar()->translation->detail), 150);
        } elseif ($key == 'robots') {
            return in_array(config('app.env'), ['prod', 'production']) ? 'index, follow' : 'noindex, nofollow';
        }

        return '';
    }

    /**
     * @param string $key
     * @return string
     */
    private function getMetaTemplate(string $key): string
    {
        if ($key == 'title') {
            return '<{0}>{1}</{0}>';
        } elseif (str()->startsWith($key, 'og:')) {
            return '<meta property="{0}" content="{1}">';
        } else {
            return '<meta name="{0}" content="{1}">';
        }
    }

    /**
     * @return string
     */
    private function getCanonical(): string
    {
        return '<link rel="canonical" href="' . url(dawnstar()->url->url) . '"/>';
    }

    /**
     * @return string
     */
    private function getAlternateLanguage(): string
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
