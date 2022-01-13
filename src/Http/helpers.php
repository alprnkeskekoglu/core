<?php

function dawnstar()
{
    return app('Dawnstar');
}

function languageFlag(string $code): string
{
    return "//flagcdn.com/h20/" . ($code == 'en' ? 'gb' : $code) . ".png";
}

function statusClass(int $status): string
{
    switch ($status) {
        case 0:
            return 'danger';
        case 1:
            return 'success';
        case 2:
            return 'secondary';
    }
}

function statusText(int $status): string
{
    return __('Core::general.status_options.' . $status);
}

function adminAction($model, string $type)
{
    $adminActionService = new \Dawnstar\Core\Services\AdminActionService($model);
    $adminActionService->create($type);
}

function searchUrl()
{
    $structure = \Dawnstar\Core\Models\Structure::where('key', 'search')
        ->first();

    if ($structure && $structure->container->translation) {
        return url($structure->container->translation->url->url);
    }
    return "javascript:void(0);";
}

function form(string $key)
{
    return (new \Dawnstar\Core\Foundation\Form($key))->init();
}

function menu(string $key)
{
    return (new \Dawnstar\Core\Foundation\Menu($key))->init();
}

function setSession()
{
    $admin = auth('admin')->user();

    $website = \Dawnstar\Core\Models\Website::where('status', 1)->where('default', 1)->first();
    if ($website) {
        $languages = $website->languages()->orderBy('pivot_default')->get();
        $defaultLanguage = $website->languages()->wherePivot('default', 1)->first();
    }

    if(isset($defaultLanguage) && in_array($defaultLanguage->code, ['tr', 'en'])) {
        $language = $defaultLanguage;
    } else {
        $language = \Dawnstar\Core\Models\Language::where('code', 'tr')->first();
    }

    session([
        'dawnstar' => [
            'admin' => $admin,
            'website' => $website,
            'languages' => $languages ?? [],
            'language' => $language ?? null,
        ]
    ]);
}

function setting(string $key, $default = null): ?string
{
    $websiteId = session('dawnstar.website.id');
    $settings = \Illuminate\Support\Facades\Cache::rememberForever('settings' . $websiteId, function () use ($websiteId) {
        return \Dawnstar\Core\Models\Setting::where('website_id', $websiteId)->pluck('value', 'key')->toArray();
    });

    if (!empty($settings[$key])) {
        return $settings[$key];
    }
    return $default;
}

function canUser(string $key, bool $hasWebsite = true)
{
    $role = auth('admin')->user()->roles->first();

    if ($role->name == 'Super Admin') {
        return true;
    }

    if ($hasWebsite) {
        $key = 'website.' . session('dawnstar.website.id') . '.' . $key;
    }

    if (!$role->hasPermissionTo($key)) {
        throw new \Dawnstar\Core\Exception\PermissionException();
    }
}

function custom(string $key, string $value = null, int $languageId = null)
{
    $languageId = $languageId ?: dawnstar()->language->id;

    $customTranslations = \Illuminate\Support\Facades\Cache::rememberForever('customTranslations_' . $languageId, function () use ($languageId) {
        return \Dawnstar\Core\Models\CustomTranslation::where('language_id', $languageId)->pluck('value', 'key')->toArray();
    });

    if (array_key_exists($key, $customTranslations)) {
        return $customTranslations[$key];
    }

    $customTranslation = \Dawnstar\Core\Models\CustomTranslation::updateOrCreate(
        [
            'language_id' => $languageId,
            'key' => $key
        ],
        [
            'value' => $value
        ]
    );


    $website = dawnstar()->website;
    $languages = $website->languages;

    foreach ($languages as $language) {
        \Dawnstar\Core\Models\CustomTranslation::firstOrCreate(
            [
                'language_id' => $languageId,
                'key' => $key
            ]
        );
    }

    \Illuminate\Support\Facades\Cache::forget('customTranslations_' . $languageId);
    return $value;
}

function buildTree(array $elements, $parentId = 0, $max = 0)
{
    $branch = array();
    foreach ($elements as $element) {
        $element['left'] = $max = $max + 1;
        $element['right'] = $max + 1;
        $element['parent_id'] = $parentId;

        if (isset($element['children'])) {
            $children = buildTree($element['children'], $element['id'], $max);
            if ($children) {

                $element['right'] = $max = (isset(end($children)['right']) ? end($children)['right'] : 1) + 1;
                $element['children'] = $children;
            } else {
                $element['right'] = $max = $max + 1;
            }
        }

        $branch[] = $element;
    }

    return unBuildTree($branch);
}

function unBuildTree($elements, $branch = [])
{
    foreach ($elements as $element) {
        if (isset($element['children'])) {
            $branch = unBuildTree($element['children'], $branch);
            unset($element['children']);
        }
        $branch[] = $element;
    }
    return $branch;
}

function panelMenu(): array
{
    return [
        [
            'name' => __('Core::panel_menu.website'),
            'url' => route('dawnstar.websites.index'),
            'icon' => 'mdi mdi-monitor',
            'children' => []
        ],
        [
            'name' => __('Core::panel_menu.structure'),
            'url' => route('dawnstar.structures.index'),
            'icon' => 'mdi mdi-tape-drive',
            'children' => []
        ],
        [
            'name' => __('Core::panel_menu.panel_management'),
            'url' => 'panel_management',
            'icon' => 'mdi mdi-account-lock',
            'children' => [
                [
                    'name' => __('Core::panel_menu.admin'),
                    'url' => route('dawnstar.admins.index')
                ],
                [
                    'name' => __('Core::panel_menu.role'),
                    'url' => route('dawnstar.roles.index')
                ],
                [
                    'name' => __('Core::panel_menu.setting'),
                    'url' => route('dawnstar.settings.index')
                ],
            ]
        ],
        [
            'name' => __('Core::panel_menu.website_management'),
            'url' => 'website_management',
            'icon' => 'mdi mdi-monitor-dashboard',
            'children' => [
                [
                    'name' => __('Core::panel_menu.menu'),
                    'url' => route('dawnstar.menus.index')
                ],
                [
                    'name' => __('Core::panel_menu.form'),
                    'url' => route('dawnstar.forms.index')
                ],
                [
                    'name' => __('Core::panel_menu.custom_translation'),
                    'url' => route('dawnstar.custom_translations.index')
                ],
            ]
        ],
    ];
}
