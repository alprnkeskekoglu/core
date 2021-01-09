<?php

namespace Dawnstar\Foundation;

use Dawnstar\Models\Category;
use Dawnstar\Models\Container;
use Dawnstar\Models\Page;

class FormBuilder
{
    public $type;
    public $container;

    public $model;
    public $modelDetail;
    public $tabLanguage;

    public $languageCode;
    public $html;

    private $models = [
        'container' => Container::class,
        'page' => Page::class,
        'category' => Category::class,
    ];

    public function __construct(string $type, int $containerId, int $id = null)
    {
        $this->type = $type;
        $this->container = Container::find($containerId);
        $this->builderFile = resource_path('views/vendor/dawnstar/form_builder/' . strtolower($this->container->key) . '/' . $type . '.php');

        $this->languageCode = session('dawnstar.language.code');

        if($id) {
            $this->model = $model->find($id);
        } else {
            $this->model = $this->container;
        }
    }

    public function render($tabLanguage = null)
    {
        $contents = [];
        if(!file_exists($this->builderFile)) {
            dd('file not exist!!'); // TODO: error
        }

        $this->tabLanguage = $tabLanguage;

        $contents = include $this->builderFile;

        if($tabLanguage) {
            $this->modelDetail = $this->model->details()->where('language_id', $tabLanguage->id)->first();
            return isset($contents['languages']) ? $this->getHtml($contents['languages']) : null;
        }
        return isset($contents['general']) ? $this->getHtml($contents['general']) : null;
    }

    public function scripts()
    {
        return view('DawnstarView::form_builder.scripts')->render();
    }

    private function getHtml(array $inputs)
    {
        $html = '';

        foreach ($inputs as $input) {
            $html .= $this->getInputHtml($input);
        }

        return $html;
    }

    private function getInputHtml(array $input)
    {
        $type = $input['type'];
        $whiteList = [
            'input', 'radio', 'checkbox', 'select', 'textarea', 'ckeditor'
        ];

        if(!in_array($type, $whiteList)) {
            throw new \Exception('Error ' . $type);
        }

        $value = $this->getInputValue($input['name']);
        $input = $this->getInput($input);


        return view('DawnstarView::form_builder.'. $type, [
            'input' => $input,
            'tabLanguage' => $this->tabLanguage,
            'dawnstarLanguageCode' => $this->languageCode,
            'value' => $value
        ])->render();
    }

    private function getInput($input)
    {
        $name = $input['name'];
        $isExtras = \Str::startsWith($name, 'extras.');
        $isDetailExtras = \Str::startsWith($name, 'detail.extras.');
        $isDetail = \Str::startsWith($name, 'detail.');
        $isMultiple = isset($input['multiple']) && $input['multiple'];

        if($isExtras) {
            $key = str_replace(['extras.'], '', $name);
            $input['name'] = 'extras['.$key.']' . ($isMultiple ? '[]' : '');
            $input['id'] = 'extras_' . $key;
        } elseif($isDetailExtras)  {
            $key = str_replace(['detail.extras.'], '', $name);
            $input['name']  = 'details['.$this->tabLanguage->id.'][extras]['.$key.']'. ($isMultiple ? '[]' : '');
            $input['id'] = 'details_' . $this->tabLanguage->id . '_extras_' . $key;
        } elseif($isDetail) {
            $key = str_replace(['detail.'], '', $name);
            $input['name']  = 'details['.$this->tabLanguage->id.']['.$key.']';
            $input['id'] = 'details_' . $this->tabLanguage->id . '_' . $key;
        } else {
            $input['name'] = $name;
            $input['id'] = $name;
        }

        return $input;
    }

    private function getInputValue($name)
    {
        if(is_null($this->tabLanguage)) {
            return $this->getNonDetailValue($name);
        }
        return $this->getDetailValue($name);
    }

    private function getNonDetailValue($name)
    {
        $isExtras = \Str::startsWith($name, 'extras.');

        if($isExtras) {
            $name = str_replace(['extras.', '[]'], '', $name);

            return $this->modelDetail->{$name};
        }
        return $this->model->{$name};
    }

    private function getDetailValue($name)
    {
        $isExtras = \Str::startsWith($name, 'detail.extras.');

        if($isExtras) {
            $name = str_replace(['detail.extras.', '[]'], '', $name);

            return $this->modelDetail->{$name};
        }
        $name = str_replace('detail.', '', $name);
        return $this->modelDetail->{$name};
    }

}
