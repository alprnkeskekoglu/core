<?php

function dawnstarAsset($path) {
    return asset('vendor/dawnstar/assets/' . $path);
}

function getStatusText($status) {
    switch ($status) {
        case 1:
            return __('DawnstarLang::general.status_title.active');
        case 2:
            return __('DawnstarLang::general.status_title.draft');
        case 3:
            return __('DawnstarLang::general.status_title.passive');
    }
}

function getStatusColorClass($status) {
    switch ($status) {
        case 1:
            return 'success';
        case 2:
            return 'secondary';
        case 3:
            return 'danger';
    }
}
