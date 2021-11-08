<?php

use Dawnstar\Http\Controllers\LoginController;

use Dawnstar\Http\Controllers\DashboardController;

use Dawnstar\Http\Controllers\WebsiteController;
use Dawnstar\Http\Controllers\StructureController;

use Dawnstar\Http\Controllers\AdminController;
use Dawnstar\Http\Controllers\AdminActionController;
use Dawnstar\Http\Controllers\ProfileController;
use Dawnstar\Http\Controllers\FormController;
use Dawnstar\Http\Controllers\FormMessageController;
use Dawnstar\Http\Controllers\CustomTranslationController;

use Dawnstar\Http\Controllers\UrlController;
use Dawnstar\Http\Controllers\PanelController;


Route::middleware(['dawnstar_guest'])->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login.index');
    Route::post('login', [LoginController::class, 'login'])->name('login');
});

Route::middleware(['dawnstar_auth'])->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('websites', WebsiteController::class)->except(['show']);

    Route::resource('structures', StructureController::class)->except(['show']);

    Route::resource('admins', AdminController::class)->except(['show']);
    Route::get('admin-actions', [AdminActionController::class, 'index'])->name('admin_actions.index');

    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('forms', FormController::class)->except(['show']);
    Route::resource('forms.messages', FormMessageController::class)->only(['index', 'show', 'destroy']);


    Route::prefix('custom-translations')->as('custom_translations.')->group(function () {
        Route::get('/', [CustomTranslationController::class, 'index'])->name('index');
        Route::get('/search', [CustomTranslationController::class, 'search'])->name('search');
        Route::put('/', [CustomTranslationController::class, 'update'])->name('update');
        Route::delete('/', [CustomTranslationController::class, 'destroy'])->name('destroy');
    });

    Route::get('getUrl', [UrlController::class, 'getUrl'])->name('getUrl');

    Route::prefix('panel')->as('panel.')->group(function () {
        Route::get('changeLanguage/{language}', [PanelController::class, 'changeLanguage'])->name('changeLanguage');
    });
});
