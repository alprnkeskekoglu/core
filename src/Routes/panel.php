<?php

use Dawnstar\Http\Controllers\WebsiteController;
use Dawnstar\Http\Controllers\CustomTranslationController;


Route::resource('websites', WebsiteController::class)->except(['show']);



Route::prefix('custom-translations')->as('custom_translations.')->group(function () {
    Route::get('/', [CustomTranslationController::class, 'index'])->name('index');
    Route::get('/search', [CustomTranslationController::class, 'search'])->name('search');
    Route::put('/', [CustomTranslationController::class, 'update'])->name('update');
    Route::delete('/', [CustomTranslationController::class, 'destroy'])->name('destroy');
});
