<?php

use Dawnstar\Http\Controllers\AuthController;

use Dawnstar\Http\Controllers\DashboardController;

use Dawnstar\Http\Controllers\WebsiteController;
use Dawnstar\Http\Controllers\AdminController;
use Dawnstar\Http\Controllers\ProfileController;

use Dawnstar\Http\Controllers\ContainerStructureController;
use Dawnstar\Http\Controllers\ContainerController;
use Dawnstar\Http\Controllers\PageController;
use Dawnstar\Http\Controllers\CategoryController;

use Dawnstar\Http\Controllers\MenuController;
use Dawnstar\Http\Controllers\MenuContentController;

use Dawnstar\Http\Controllers\FormController;
use Dawnstar\Http\Controllers\FormResultController;

use Dawnstar\Http\Controllers\CustomContentController;
use Dawnstar\Http\Controllers\ToolController;

use Dawnstar\Http\Controllers\RoleController;
use Dawnstar\Http\Controllers\PermissionController;

use Dawnstar\Http\Controllers\FormBuilderController;
use Dawnstar\Http\Controllers\PanelController;


Route::middleware(['dawnstar.guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('auth.index');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
});
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::middleware(['dawnstar.auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/getOnlineCount', [DashboardController::class, 'getOnlineCount'])->name('dashboard.getOnlineCount');

    Route::resource('websites', WebsiteController::class)->except(['show']);
    Route::resource('admins', AdminController::class)->except(['show']);

    # Profile
    Route::prefix('profiles')->as('profiles.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
    });

    # Container Structure, Containers, Pages and Categories
    Route::resource('containers/structures', ContainerStructureController::class, ['as' => 'containers'])->parameters(['structures' => 'container'])->except(['show']);
    Route::resource('containers', ContainerController::class)->only(['edit', 'update']);
    Route::resource('containers.pages', PageController::class)->except(['show']);
    Route::resource('containers.categories', CategoryController::class)->except(['show']);
    Route::prefix('containers')->as('containers.')->group(function () {
        Route::get('/getUrl', [ContainerController::class, 'getUrl'])->name('getUrl');

        Route::prefix('/{container}')->group(function () {
            Route::get('/pages/getPageList', [PageController::class, 'getPageList'])->name('pages.getPageList');
            Route::get('/categories/saveOrder', [CategoryController::class, 'saveOrder'])->name('categories.saveOrder');
        });
    });


    # Menu and Menu Contents
    Route::get('/menus/getUrls', [MenuContentController::class, 'getUrls'])->name('menus.getUrls');
    Route::resource('menus', MenuController::class)->except(['show']);
    Route::post('/menus/{menu}/saveOrder', [MenuController::class, 'saveOrder'])->name('menus.saveOrder');
    Route::resource('menus.contents', MenuContentController::class)->parameters(['contents' => 'menuContent'])->except(['index', 'show']);


    # Form and Form Results
    Route::resource('forms', FormController::class)->except(['show']);
    Route::prefix('forms/{form}/results')->as('forms.results.')->group(function () {
        Route::get('/', [FormResultController::class, 'index'])->name('index');
        Route::get('/updateReadStatus', [FormResultController::class, 'updateReadStatus'])->name('updateReadStatus');
    });

    # Custom Contents
    Route::prefix('custom-contents')->as('custom_contents.')->group(function () {
        Route::get('/', [CustomContentController::class, 'index'])->name('index');
        Route::put('/update', [CustomContentController::class, 'update'])->name('update');
        Route::delete('/destory', [CustomContentController::class, 'delete'])->name('delete');
        Route::get('/search', [CustomContentController::class, 'search'])->name('search');
    });

    # Tools
    Route::prefix('tools')->as('tools.')->group(function () {
        Route::get('/', [ToolController::class, 'index'])->name('index');
        Route::get('/env', [ToolController::class, 'env'])->name('env');
        Route::put('/env/update', [ToolController::class, 'envUpdate'])->name('env.update');
        Route::post('/init', [ToolController::class, 'init'])->name('init');
    });

    # Form Builders
    Route::prefix('form-builders')->as('form_builders.')->group(function () {
        Route::get('/', [FormBuilderController::class, 'index'])->name('index');
        Route::get('/edit/{id}/{type}', [FormBuilderController::class, 'edit'])->name('edit');
        Route::get('/showModal', [FormBuilderController::class, 'showModal'])->name('showModal');
        Route::get('/showNewModal', [FormBuilderController::class, 'showNewModal'])->name('showNewModal');
        Route::post('/deleteElement', [FormBuilderController::class, 'deleteElement'])->name('deleteElement');
        Route::post('/saveElement', [FormBuilderController::class, 'saveElement'])->name('saveElement');
        Route::post('/saveOrder', [FormBuilderController::class, 'saveOrder'])->name('saveOrder');


        Route::get('/getCountries', [FormBuilderController::class, 'getCountries'])->name('getCountries');
    });

    # Roles
    Route::resource('roles', RoleController::class)->except(['show']);
    Route::resource('roles.permissions', PermissionController::class)->only(['index', 'store']);

    # Panel
    Route::prefix('panel')->as('panel.')->group(function () {
        Route::get('/changeLanguage/{code}', [PanelController::class, 'changeLanguage'])->name('changeLanguage');
        Route::get('/changeWebsite/{id}', [PanelController::class, 'changeWebsite'])->name('changeWebsite');
    });
});
