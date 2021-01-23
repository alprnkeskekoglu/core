<?php

namespace Dawnstar\Foundation;

use Dawnstar\Models\Category;
use Dawnstar\Models\Container;
use Dawnstar\Models\Page;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class FormBuilder
{
    public $type;
    public $container;

    public $categories;

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

        if ($type == 'container') {
            $this->model = $this->container;
        } elseif ($id && isset($this->models[$type])) {
            $model = $this->models[$type];

            $this->model = $model::find($id);
        }
    }

    public function render($tabLanguage = null)
    {
        $contents = [];
        if (!file_exists($this->builderFile)) {
            throw new FileNotFoundException($this->builderFile . ' does not exist!!');
        }

        $this->tabLanguage = $tabLanguage;

        $contents = include $this->builderFile;

        if ($tabLanguage) {
            $this->modelDetail = $this->model ? $this->model->details()->where('language_id', $tabLanguage->id)->first() : null;
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
            'input', 'radio', 'checkbox', 'select', 'textarea', 'ckeditor', 'date', 'category'
        ];

        if (!in_array($type, $whiteList)) {
            throw new \Exception('Error ' . $type);
        }

        $value = $this->getInputValue($input['name']);
        $input = $this->getInput($input);


        return view('DawnstarView::form_builder.' . $type, [
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
        $isCategory = $input['type'] == 'category';

        if ($isExtras) {
            $key = str_replace(['extras.'], '', $name);
            $input['name'] = 'extras[' . $key . ']' . ($isMultiple ? '[]' : '');
            $input['id'] = 'extras_' . $key;
        } elseif ($isDetailExtras) {
            $key = str_replace(['detail.extras.'], '', $name);
            $input['name'] = 'details[' . $this->tabLanguage->id . '][extras][' . $key . ']' . ($isMultiple ? '[]' : '');
            $input['id'] = 'details_' . $this->tabLanguage->id . '_extras_' . $key;
        } elseif ($isDetail) {
            $key = str_replace(['detail.'], '', $name);
            $input['name'] = 'details[' . $this->tabLanguage->id . '][' . $key . ']';
            $input['id'] = 'details_' . $this->tabLanguage->id . '_' . $key;
        } elseif ($isCategory) {

            $input['name'] = $name . '[]';
            $input['id'] = $name;

            if (isset($input['sitemap_id'])) {
                $container = Container::findOrFail($input['sitemap_id']);
            } else {
                $container = $this->container;
            }

            $categories = $container->categories()
                ->where('parent_id', 0)
                ->orderBy('lft')
                ->get();

            $input['categories'] = $this->getCategories($categories);

        } else {
            $input['name'] = $name;
            $input['id'] = $name;
        }

        return $input;
    }

    # region getValues
    private function getInputValue($name)
    {
        if (is_null($this->model)) {
            return null;
        }

        if (is_null($this->tabLanguage)) {
            return $this->getNonDetailValue($name);
        }
        return $this->getDetailValue($name);
    }

    private function getNonDetailValue($name)
    {
        $isExtras = \Str::startsWith($name, 'extras.');
        $isCategory = \Str::startsWith($name, 'categories');

        if ($isExtras) {
            $name = str_replace(['extras.', '[]'], '', $name);
        } else if($isCategory) {
            return $this->model->categories->pluck('id')->toArray();
        }
        return $this->model->{$name};
    }

    private function getDetailValue($name)
    {
        $isExtras = \Str::startsWith($name, 'detail.extras.');

        if ($isExtras) {
            $name = str_replace(['detail.extras.', '[]'], '', $name);

            return $this->modelDetail->{$name};
        }
        $name = str_replace('detail.', '', $name);
        return $this->modelDetail->{$name};
    }

    # endregion

    private function getCategories($categories)
    {
        $hold = [];
        foreach ($categories as $category) {

            $id = $category->id;
            $text = $category->detail->name;
            $hold[$id] = $text;

            if ($category->children->isNotEmpty()) {
                foreach ($category->children as $categoryChild) {

                    $id = $categoryChild->id;
                    $text .= ' >> ' . $categoryChild->detail->name;
                    $hold[$id] = $text;

                    if ($categoryChild->children->isNotEmpty()) {
                        foreach ($categoryChild->children as $categoryChildCh) {
                            $id = $categoryChild->id;
                            $text .= ' >> ' . $categoryChildCh->detail->name;
                            $hold[$id] = $text;
                        }
                    }
                }
            }
        }

        return $hold;
    }
}
