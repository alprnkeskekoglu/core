<?php

function dawnstar() {
    return app('Dawnstar');
}

function menu(string $key) {
    $dawnstar = dawnstar();

    $websiteId = $dawnstar->website->id;
    $languageId = $dawnstar->language->id;

    return \Illuminate\Support\Facades\Cache::rememberForever('menu' . $key . $websiteId . $languageId, function () use($key) {
        return (new \Dawnstar\Foundation\Menu($key))->init();
    });
}

function custom(string $key, string $value = null, int $languageId = null) {

    $dawnstar = dawnstar();

    $websiteId = $dawnstar->website->id;
    if(is_null($languageId)) {
        $languageId = $dawnstar->language->id;
    }

    return \Illuminate\Support\Facades\Cache::rememberForever('customContent' . $websiteId . $languageId . $key, function () use($dawnstar, $languageId, $websiteId, $key, $value) {

        foreach ($dawnstar->website->languages as $language) {
            if($languageId == $language->id) {
                continue;
            }

            \Dawnstar\Models\CustomContent::firstOrCreate(
                [
                    'website_id' => $websiteId,
                    'language_id' => $language->id,
                    'key' => $key
                ],
            );
        }

        $customContent = \Dawnstar\Models\CustomContent::firstOrCreate(
            [
                'website_id' => $websiteId,
                'language_id' => $languageId,
                'key' => $key
            ],
            [
                'value' => $value
            ]
        );

        return $customContent->value;
    });
}

function searchUrl()
{
    $container = \Dawnstar\Models\Container::where('key', 'search')
        ->first();

    if ($container && $container->detail) {
        return url($container->detail->url->url);
    }
    return "javascript:void(0);";
}

function addAction($model, $action)
{
    $adminId = session('dawnstar.admin.id');
    $websiteId = session('dawnstar.website.id') ?: 1;
    $modelClass = get_class($model);
    $modelId = $model->id;

    \Dawnstar\Models\AdminAction::create([
        'website_id' => $websiteId,
        'admin_id' => $adminId,
        'model_type' => $modelClass,
        'model_id' => $modelId,
        'action' => $action
    ]);
}

function dawnstarAsset($path)
{
    return asset('vendor/dawnstar/assets/' . $path);
}

function getStatusText($status)
{
    switch ($status) {
        case 1:
            return __('DawnstarLang::general.status_title.active');
        case 2:
            return __('DawnstarLang::general.status_title.draft');
        case 3:
            return __('DawnstarLang::general.status_title.passive');
    }
}

function getStatusColorClass($status)
{
    switch ($status) {
        case 1:
            return 'success';
        case 2:
            return 'secondary';
        case 3:
            return 'danger';
    }
}

function formBuilderLabel($input, $languageCode) {
    return $input['label']['text'][$languageCode] ?? (isset($input['label']['text']) ? array_shift($input['label']['text']) : '');
}

function dawnstarMenu()
{
    return \Illuminate\Support\Facades\Cache::rememberForever('dawnstarMenu' . session('dawnstar.website.id'), function() {

        $menu = [];

        $containers = \Dawnstar\Models\Container::where('website_id', session('dawnstar.website.id'))->get();
        foreach ($containers as $container) {
            if ($container->type == 'static') {
                $url = route('dawnstar.containers.edit', ['id' => $container->id]);
            } else {
                $url = route('dawnstar.containers.pages.index', ['containerId' => $container->id]);
            }

            $menu[] = [
                'name' => $container->detail->name,
                'url' => $url,
            ];
        }
        return $menu;
    });
}
