<?php

namespace Dawnstar\Foundation;

use Dawnstar\Models\Container;

class FormBuilder
{
    public $containerId;
    public $type;
    public $container;

    public $html;

    public function __construct(int $containerId, string $type)
    {
        $this->containerId = $containerId;
        $this->type = $type;

        $this->container = Container::find($containerId);
        $this->builderFile = resource_path('views/vendor/dawnstar/form_builder/' . strtolower($this->container->key) . '/' . $type . '.php');
    }

    public function render(int $languageId = null)
    {
        $contents = [];
        if(!file_exists($this->builderFile)) {
            dd('file not exist!!'); // TODO: error
        }

        $contents = include $this->builderFile;
        return $this->getHtml($contents, $languageId);
    }

    private function getHtml(array $contents, int $languageId = null)
    {
        if($languageId) {
            return null;
        }
        return isset($contents['general']) ? $this->getGeneralTab($contents['general']) : null;
    }

    private function getGeneralTab(array $inputs)
    {
        $generalHtml = '';

        foreach ($inputs as $input) {
            $generalHtml .= $this->getInputHtml($input);
        }

        return $generalHtml;
    }

    private function getInputHtml(array $input)
    {
        $whiteList = [
            'input', 'radio', 'checkbox', 'select', 'textarea', 'ckeditor'
        ];

        if(!in_array($input['type'], $whiteList)) {
            throw new \Exception('Error ' . $input['type']);
        }


        $languageCode = session('dawnstar.language.code');

        return view('DawnstarView::form_builder.'. $input['type'], ['input' => $input, 'languageCode' => $languageCode, 'container' => $this->container])->render();
    }


}
