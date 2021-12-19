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
    return __('Dawnstar::general.status_options.' . $status);
}

function adminAction($model, string $type)
{
    $adminActionService = new \Dawnstar\Services\AdminActionService($model);
    $adminActionService->create($type);
}

function canUser(string $key, bool $hasWebsite = true)
{
    $user = auth('admin')->user();
    $role = $user->roles->first();

    if($role->name == 'Super Admin') {
        return true;
    }

    if ($hasWebsite) {
        $key = 'website.' . session('dawnstar.website.id') . '.' . $key;
    }

    if (!$role->hasPermissionTo($key)) {
        throw new \Dawnstar\Exception\PermissionException();
    }
}

function custom(string $key, string $value = null, int $languageId = null)
{
    return $key;

    $languageId = $languageId ?: 164;

    $customTranslations = \Illuminate\Support\Facades\Cache::rememberForever('customTranslations_' . $languageId, function () use ($languageId) {
        return \Dawnstar\Models\CustomTranslation::where('language_id', $languageId)->pluck('value', 'key')->toArray();
    });

    if (array_key_exists($key, $customTranslations)) {
        return $customTranslations[$key];
    }

    $customTranslation = \Dawnstar\Models\CustomTranslation::updateOrCreate(
        [
            'language_id' => $languageId,
            'key' => $key
        ],
        [
            'value' => $value
        ]
    );


    $languages = [84]; // TODO

    foreach ($languages as $language) {
        \Dawnstar\Models\CustomTranslation::firstOrCreate(
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
        $element['rigt'] = $max + 1;
        $element['parent_id'] = $parentId;

        if (isset($element['children'])) {
            $children = buildTree($element['children'], $element['id'], $max);
            if ($children) {

                $element['rgt'] = $max = (isset(end($children)['rgt']) ? end($children)['rgt'] : 1) + 1;
                $element['children'] = $children;
            } else {
                $element['rgt'] = $max = $max + 1;
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
            'name' => __('Dawnstar::panel_menu.website'),
            'url' => route('dawnstar.websites.index'),
            'icon' => 'mdi mdi-monitor',
            'children' => []
        ],
        [
            'name' => __('Dawnstar::panel_menu.structure'),
            'url' => route('dawnstar.structures.index'),
            'icon' => 'mdi mdi-tape-drive',
            'children' => []
        ],
        [
            'name' => __('Dawnstar::panel_menu.panel_management'),
            'url' => 'panel_management',
            'icon' => 'mdi mdi-account-lock',
            'children' => [
                [
                    'name' => __('Dawnstar::panel_menu.admin'),
                    'url' => route('dawnstar.admins.index')
                ],
                [
                    'name' => __('Dawnstar::panel_menu.role'),
                    'url' => route('dawnstar.roles.index')
                ]
            ]
        ],
        [
            'name' => __('Dawnstar::panel_menu.website_management'),
            'url' => 'website_management',
            'icon' => 'mdi mdi-monitor-dashboard',
            'children' => [
                [
                    'name' => __('Dawnstar::panel_menu.menu'),
                    'url' => route('dawnstar.menus.index')
                ],
                [
                    'name' => __('Dawnstar::panel_menu.form'),
                    'url' => route('dawnstar.forms.index')
                ],
                [
                    'name' => __('Dawnstar::panel_menu.custom_translation'),
                    'url' => route('dawnstar.custom_translations.index')
                ],
            ]
        ],
    ];
}
