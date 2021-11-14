<?php

namespace Dawnstar\Services;

use Dawnstar\Models\Language;
use Dawnstar\Models\ModuleBuilder;
use Dawnstar\Models\Structure;
use Illuminate\Database\Eloquent\Model;
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

    private function getActiveLanguages()
    {
        $activeLanguageIds = $this->structure->container->translations()->active()->pluck('language_id')->toArray();
        return Language::whereIn('id', $activeLanguageIds)->get();
    }

    private function getInputHtml(array $input): string
    {

        $whiteList = [
            'input', 'slug'
        ];

        if (!in_array($input['element'], $whiteList)) {
            return '';
        }

        $input['value'] = $this->getValue($input);
        $this->setInput($input);

        return view('Dawnstar::module_builder_inputs.' . $input['element'], [
            'input' => $input,
            'languages' => $this->languages
        ])->render();
    }

    private function setInput(array &$input)
    {
        $this->setInputNameAndId($input);
        $this->setLabel($input);
    }

    private function setInputNameAndId(array &$input)
    {
        $element = $input['element'] ?? null;
        $input['id'] = $input['name'];
        if ($input['translation']) {
            if ($element == 'media') {
                $input['id'] = "translations_medias_{$input['name']}";
                $input['name'] = "translations[medias][{$input['name']}]";
            } else {
                $input['id'] = "translations_{$input['name']}";
                $input['name'] = "translations[{$input['name']}]";
            }
        } elseif ($element == 'media') {
            $input['id'] = "medias_{$input['name']}";
            $input['name'] = "medias[{$input['name']}]";
        }
    }

    private function setLabel(array &$input)
    {
        $label = $input['labels'][session('dawnstar.language.id')] ?? '';
        unset($input['labels']);

        if($input['translation']) {
            foreach ($this->languages as $language) {
                $input['labels'][$language->id] = $label . ' (' . strtoupper($language->code) . ')';
            }
        } else {
            $input['label'] = $label;
        }
    }

    #region Value
    private function getValue(array $input)
    {
        if (is_null($this->model)) {
            return null;
        }

        if ($input['translation']) {
            return $this->getTranslationValue($input);
        }
        return $this->getValueNoNTranslationValue($input);
    }

    private function getNonTranslationValue(array $input)
    {
        $name = $input['name'];

        return $this->model->{$name}; //TODO Media
    }

    private function getTranslationValue(array $input)
    {
        $name = $input['name'];

        return $this->model->translation->{$name}; //TODO Media
    }
    #endregion
}
