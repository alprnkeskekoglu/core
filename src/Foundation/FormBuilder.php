<?php

namespace Dawnstar\Foundation;

use Dawnstar\Models\Category;
use Dawnstar\Models\Container;
use Dawnstar\Models\Page;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Cache;

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

    public function metas($tabLanguage)
    {
        if (!file_exists($this->builderFile)) {
            throw new FileNotFoundException($this->builderFile . ' does not exist!!');
        }

        $this->tabLanguage = $tabLanguage;

        $contents = include $this->builderFile;
        $this->modelDetail = $this->model ? $this->model->details()->where('language_id', $tabLanguage->id)->first() : null;
        return $this->getMetaHtml($contents['metas'] ?? []);
    }

    public function scripts()
    {
        return view('DawnstarView::form_builder.scripts')->render();
    }

    # region Get Inputs
    private function getHtml(array $inputs)
    {
        return Cache::rememberForever('formBuilder' . is_null($this->tabLanguage) . $this->type . $this->container->id . $this->languageCode, function () use($inputs){
            $html = '';

            foreach ($inputs as $input) {
                $html .= $this->getInputHtml($input);
            }
        });
    }

    private function getInputHtml(array $input)
    {
        $type = $input['type'];
        $whiteList = [
            'input', 'radio', 'checkbox', 'select', 'textarea', 'ckeditor', 'date', 'category', 'media'
        ];

        if (!in_array($type, $whiteList)) {
            throw new \Exception('Error ' . $type);
        }

        $value = $this->getInputValue($input);
        $input = $this->getInput($input);


        return view('DawnstarView::form_builder.' . $type, [
            'input' => $input,
            'tabLanguage' => $this->tabLanguage,
            'dawnstarLanguageCode' => $this->languageCode,
            'value' => $value,
            'container' => $this->container,
            'type' => $this->type
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
        $isMedia = $input['type'] == 'media';

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
            if ($isMedia) {
                $input['name'] = 'details[' . $this->tabLanguage->id . '][medias][' . $key . ']';
                $input['id'] = 'details_' . $this->tabLanguage->id . '_' . $key;
            } else {
                $input['name'] = 'details[' . $this->tabLanguage->id . '][' . $key . ']';
                $input['id'] = 'details_' . $this->tabLanguage->id . '_' . $key;
            }
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

        } elseif ($isMedia) {
            $input['name'] = 'medias[' . $input['name'] . ']';
            $input['id'] = $name;
        } else {
            $input['name'] = $name;
            $input['id'] = $name;
        }

        return $input;
    }

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
    # endregion

    # region Get Values
    private function getInputValue($input)
    {
        if (is_null($this->model)) {
            return null;
        }

        if (is_null($this->tabLanguage)) {
            return $this->getNonDetailValue($input);
        }
        if ($this->modelDetail) {
            return $this->getDetailValue($input);
        }
        return null;
    }

    private function getNonDetailValue($input)
    {
        $name = $input['name'];

        $isExtras = \Str::startsWith($name, 'extras.');
        $isCategory = \Str::startsWith($name, 'categories');
        $isMedia = $input['type'] == 'media';

        if ($isExtras) {
            $name = str_replace(['extras.', '[]'], '', $name);
        } else if ($isCategory) {
            return $this->model->categories->pluck('id')->toArray();
        } else if ($isMedia) {
            return $this->model->medias()->wherePivot('media_key', $name)->pluck('id')->toArray();
        }
        return $this->model->{$name};
    }

    private function getDetailValue($input)
    {
        $name = $input['name'];

        $isExtras = \Str::startsWith($name, 'detail.extras.');
        $isMedia = $input['type'] == 'media';

        if ($isExtras) {
            $name = str_replace(['detail.extras.', '[]'], '', $name);
            return $this->modelDetail->{$name};
        } else if ($isMedia) {
            $name = str_replace(['detail.', '[]'], '', $name);
            return $this->modelDetail->medias()->wherePivot('media_key', $name)->pluck('id')->toArray();
        }
        $name = str_replace('detail.', '', $name);
        return $this->modelDetail->{$name};
    }
    # endregion

    # region Get Metas
    private function getMetaHtml(array $inputs)
    {
        $html = '';

        if(count($inputs) == 0) {
            $inputs = [
                [
                    'type' => 'title',
                ],
                [
                    'type' => 'description',
                ]
            ];
        }

        foreach ($inputs as $input) {

            $key = $input['type'];

            $input['name'] = 'metas[' . $this->tabLanguage->id . '][' . $key . ']';
            $input['id'] = 'metas_' . $this->tabLanguage->id . '_' . $key;
            $meta = $this->modelDetail ? $this->modelDetail->url->getMeta($key) : '';

            $html .= view('DawnstarView::form_builder.meta', [
                'input' => $input,
                'tabLanguage' => $this->tabLanguage,
                'dawnstarLanguageCode' => $this->languageCode,
                'meta' => $meta,
            ])->render();
        }

        return $html;
    }
    # endregion
}
