<?php

namespace Dawnstar\Services;

use Dawnstar\Models\Language;
use Dawnstar\Models\ModuleBuilder;
use Dawnstar\Models\Structure;
use Dawnstar\Region\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class ModuleBuilderService
{
    public ModuleBuilder $builder;
    public Structure $structure;
    public ?Model $model;
    public string $type;
    public $languages;

    public function __construct(Structure $structure, string $type, Model $model = null)
    {
        $this->structure = $structure;
        $this->model = $model;
        $this->type = $type;
        $this->builder = $structure->moduleBuilders()->where('type', $type)->first();
        $this->languages = $this->getActiveLanguages();
    }

    public function html(): string
    {
        $inputs = $this->builder->data;

        $html = '';
        foreach ($inputs as $input) {
            $html .= $this->getInputHtml($input);
        }
        return $html;
    }

    public function validate()
    {
        request()->validate(...$this->getValidationData());
    }

    private function getActiveLanguages()
    {
        $activeLanguageIds = $this->structure->container->translations()->active()->pluck('language_id')->toArray();
        return Language::whereIn('id', $activeLanguageIds)->get();
    }

    #region Input
    private function getInputHtml(array $input): string
    {
        $whiteList = [
            'input', 'slug', 'textarea', 'radio', 'checkbox', 'select', 'country', 'media'
        ];

        if (!in_array($input['element'], $whiteList)) {
            return '';
        }

        $this->setInput($input);

        return view('Dawnstar::module_builder_inputs.' . $input['element'], [
            'input' => $input,
            'languages' => $this->languages
        ])->render();
    }

    private function setInput(array &$input)
    {
        $this->setValue($input);
        $this->setInputNameAndId($input);
        $this->setLabel($input);

        if (in_array($input['element'], ['radio', 'checkbox', 'select', 'country', 'city'])) {
            $this->setOptions($input);
        }
    }

    private function setInputNameAndId(array &$input)
    {
        $element = $input['element'] ?? null;

        $input['key'] = $input['id'] = $input['name'];

        if ($element == 'media') {
            $input['id'] = "medias_{$input['name']}";
            $input['column'] = $input['name'];
            $input['key'] = "medias.{$input['name']}";
            $input['name'] = $input['translation'] ? "medias][{$input['name']}" : "medias[{$input['name']}]";
        }

        $name = $id = $key = [];
        if ($input['translation'] == 'true') {
            foreach ($this->languages as $language) {
                $id[$language->id] = "translations_{$language->id}_" . $input['id'];
                $key[$language->id] = "translations.{$language->id}." . $input['key'];
                $name[$language->id] = "translations[{$language->id}][" . $input['name'] . "]";
            }
            $input['id'] = $id;
            $input['key'] = $key;
            $input['name'] = $name;
        }
    }

    private function setLabel(array &$input)
    {
        $label = $input['labels'][session('dawnstar.language.id')] ?? '';
        unset($input['labels']);

        if ($input['translation'] == 'true') {
            foreach ($this->languages as $language) {
                $input['label'][$language->id] = $label . ' (' . strtoupper($language->code) . ')';
            }
        } else {
            $input['label'] = $label;
        }
    }

    private function setOptions(array &$input)
    {
        $options = [];

        if($input['element'] == 'country') {
            $options = $this->getCountry();
        }

        foreach ($input['options'] as $option) {
            $options[$option['key']] = $option['value'][session('dawnstar.language.id')];
        }

        $input['options'] = $options;
    }
    #endregion

    #region Value
    private function setValue(array &$input)
    {
        if ($input['translation'] == 'true') {
            $input['value'] = $this->getTranslationValue($input);
        } else {
            $input['value'] = $this->getNonTranslationValue($input);
        }
    }

    private function getNonTranslationValue(array $input)
    {
        $name = $input['name'];

        if($this->model && $input['element'] == 'media') {
            return $this->model->medias()->wherePivot('key', $name)->orderBy('model_medias.order')->pluck('id')->toArray();
        }

        return old($input['name'], ($this->model ? $this->model->{$name} : null)); //TODO Media
    }

    private function getTranslationValue(array $input)
    {
        if(is_null($this->model)) {
            return null;
        }

        $name = $input['name'];
        $translations = optional($this->model)->translations;

        $values = [];
        foreach ($this->languages as $language) {//TODO Media
            $translation = $translations ? $translations->where('language_id', $language->id)->first() : null;


            if($translation && $input['element'] == 'media') {
                $values[$language->id] = $translation->medias()->wherePivot('key', $name)->orderBy('model_medias.order')->pluck('id')->toArray();
            } else {
                $values[$language->id] = old("translations.{$language->id}.$name", ($translation ? $translation->{$name} : null));
            }
;
        }
        return $values;
    }
    #endregion

    #region Validation
    private function getValidationData()
    {
        $rules = $attributes = [];
        $inputs = $this->builder->data;

        foreach ($inputs as $input) {
            if (isset($input['rules'])) {
                $this->setRules($rules, $input);
                $this->setAttributes($attributes, $input);
            }
        }
        return [$rules, [], $attributes];
    }

    private function setRules(array &$rules, array $input)
    {
        $element = $input['element'] ?? null;

        if ($input['translation'] == 'true') {
            foreach ($this->languages as $language) {
                if ($element == 'media') {
                    $rules["translations.{$language->id}.medias.{$input['name']}"] = $input['rules'];
                } else {
                    $rules["translations.{$language->id}.{$input['name']}"] = $input['rules'];
                }
            }
        } elseif ($element == 'media') {
            $rules["medias.{$input['name']}"] = $input['rules'];
        } else {
            $rules[$input['name']] = $input['rules'];
        }
    }

    private function setAttributes(array &$attributes, array $input)
    {
        $element = $input['element'] ?? null;
        $panelLanguage = session('dawnstar.language');

        if ($input['translation'] == 'true') {
            foreach ($this->languages as $language) {
                if ($element == 'media') {
                    $attributes["translations.{$language->id}.medias.{$input['name']}"] = $input['labels'][$panelLanguage->id] . ' (' . strtoupper($language->code) . ')';
                } else {
                    $attributes["translations.{$language->id}.{$input['name']}"] = $input['labels'][$panelLanguage->id] . ' (' . strtoupper($language->code) . ')';
                }
            }
        } elseif ($element == 'media') {
            $attributes["medias.{$input['name']}"] = $input['labels'][$panelLanguage->id];
        } else {
            $attributes[$input['name']] = $input['labels'][$panelLanguage->id];
        }
    }
    #endregion

    private function getCountry()
    {
        $languageCode = session('dawnstar.language.code');
        return Cache::rememberForever('module_builder_country_' . $languageCode, function () use($languageCode) {
            return Country::all()->pluck("name_{$languageCode}", 'id');
        });
    }
}
