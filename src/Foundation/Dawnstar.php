<?php

namespace Dawnstar\Foundation;

use Dawnstar\Models\CategoryDetail;
use Dawnstar\Models\Container;
use Dawnstar\Models\ContainerDetail;
use Dawnstar\Models\Language;
use Dawnstar\Models\PageDetail;
use Dawnstar\Models\Url;
use Dawnstar\Models\Website;

/**
 * Class Dawnstar
 * @package Dawnstar\Foundation
 * @property Website website
 * @property Url url
 * @property Language language
 * @property ContainerDetail|PageDetail|CategoryDetail relation
 * @property Container container
 * @property array data
 */
class Dawnstar
{
    public $data = [];

    public function __construct()
    {
        view()->share("dawnstar", $this);
    }

    public function defaultLanguage()
    {
        $this->website->defaultLanguage();
    }

    public function otherLanguages(bool $removeActiveLanguage = true)
    {
        if(is_a($this->relation, ContainerDetail::class)) {
            $parent = $this->relation->container;
        } elseif(is_a($this->relation, PageDetail::class)) {
            $parent = $this->relation->page;
        } elseif(is_a($this->relation, CategoryDetail::class)) {
            $parent = $this->relation->category;
        }

        $languageIds = $parent->details->pluck('language_id')->toArray();

        $languages = Language::whereIn('id', $languageIds);

        if($removeActiveLanguage) {
            $languages = $languages->where('id', '<>', $this->language->id);
        }

        return $languages->get();
    }
}
