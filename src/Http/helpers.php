<?php

function addAction($model, $action)
{
    $adminId = session('dawnstar.admin.id');
    $websiteId = session('dawnstar.website.id') ?: 1;
    $modelClass = get_class($model);
    $modelId = $model->id;

    \Dawnstar\Models\AdminAction::create([
        'website_id' => $websiteId,
        'admin_id' => $adminId,
        'model_class' => $modelClass,
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
