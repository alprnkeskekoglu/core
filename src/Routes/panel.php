<?php

use Dawnstar\Http\Controllers\LoginController;

use Dawnstar\Http\Controllers\DashboardController;

use Dawnstar\Http\Controllers\WebsiteController;
use Dawnstar\Http\Controllers\StructureController;
use Dawnstar\Http\Controllers\ContainerController;
use Dawnstar\Http\Controllers\PageController;
use Dawnstar\Http\Controllers\CategoryController;

use Dawnstar\Http\Controllers\AdminController;
use Dawnstar\Http\Controllers\RoleController;
use Dawnstar\Http\Controllers\AdminActionController;
use Dawnstar\Http\Controllers\ProfileController;

use Dawnstar\Http\Controllers\MenuController;
use Dawnstar\Http\Controllers\MenuItemController;

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
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/getReport', [DashboardController::class, 'getReport'])->name('dashboard.getReport');

    Route::resource('websites', WebsiteController::class)->except(['show']);

    Route::middleware(['default_website'])->group(function () {
        Route::resource('structures', StructureController::class)->except(['show']);
        Route::resource('structures.containers', ContainerController::class)->only(['edit', 'update']);

        Route::get('structures/{structure}/pages/datatable', [PageController::class, 'datatable'])->name('structures.pages.datatable');
        Route::resource('structures.pages', PageController::class)->except(['show']);

        Route::post('structures/{structure}/categories/saveOrder', [CategoryController::class, 'saveOrder'])->name('structures.categories.saveOrder');
        Route::resource('structures.categories', CategoryController::class)->except(['create', 'show']);

        Route::resource('admins', AdminController::class)->except(['show']);
        Route::get('admin-actions', [AdminActionController::class, 'index'])->name('admin_actions.index');

        Route::resource('roles', RoleController::class)->except(['show']);
        Route::resource('roles.permissions', PermissionController::class)->only(['index', 'store']);

        Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::resource('menus', MenuController::class)->except(['show']);
        Route::get('menus/{menu}/items/getUrls', [MenuItemController::class, 'getUrls'])->name('menus.items.getUrls');
        Route::post('menus/{menu}/items/saveOrder', [MenuItemController::class, 'saveOrder'])->name('menus.items.saveOrder');
        Route::resource('menus.items', MenuItemController::class)->except(['create', 'show']);

        Route::resource('forms', FormController::class)->except(['show']);
        Route::resource('forms.messages', FormMessageController::class)->only(['index', 'show', 'destroy']);

        Route::prefix('custom-translations')->as('custom_translations.')->group(function () {
            Route::get('/', [CustomTranslationController::class, 'index'])->name('index');
            Route::get('/search', [CustomTranslationController::class, 'search'])->name('search');
            Route::put('/', [CustomTranslationController::class, 'update'])->name('update');
            Route::delete('/', [CustomTranslationController::class, 'destroy'])->name('destroy');
        });
    });

    Route::get('getUrl', [UrlController::class, 'getUrl'])->name('getUrl');

    Route::prefix('panel')->as('panel.')->group(function () {
        Route::get('changeLanguage/{language}', [PanelController::class, 'changeLanguage'])->name('changeLanguage');
    });
});
