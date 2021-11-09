<?php

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

function adminAction($model, string $type) {
    $adminActionService = new \Dawnstar\Services\AdminActionService($model);
    $adminActionService->create($type);
}

function custom(string $key, string $value = null, int $languageId = null) {
    return $key;

    $languageId = $languageId ?: 164;

    $customTranslations = \Illuminate\Support\Facades\Cache::rememberForever('customTranslations_' . $languageId, function () use($languageId) {
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

