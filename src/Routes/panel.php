<?php

Route::middleware(['dawnstar.guest'])->group(function () {
    Route::get('/login', 'AuthController@index')->name('auth.index');
    Route::post('/login', 'AuthController@login')->name('auth.login');
});
Route::get('/logout', 'AuthController@logout')->name('auth.logout');

Route::middleware(['dawnstar.auth'])->group(function () {

    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::prefix('Website')->as('website.')->group(function () {
        Route::get('/', 'WebsiteController@index')->name('index');
        Route::get('/create', 'WebsiteController@create')->name('create');
        Route::post('/store', 'WebsiteController@store')->name('store');
        Route::get('/edit/{id}', 'WebsiteController@edit')->name('edit');
        Route::post('/update/{id}', 'WebsiteController@update')->name('update');
        Route::post('/delete/{id}', 'WebsiteController@delete')->name('delete');
    });

    Route::prefix('Container')->as('container.')->group(function () {
        Route::get('/', 'ContainerController@index')->name('index');
        Route::get('/create', 'ContainerController@create')->name('create');
        Route::post('/store', 'ContainerController@store')->name('store');
        Route::get('/edit/{id}', 'ContainerController@edit')->name('edit');
        Route::post('/update/{id}', 'ContainerController@update')->name('update');
        Route::post('/delete/{id}', 'ContainerController@delete')->name('delete');

        Route::get('/getUrl', 'ContainerController@getUrl')->name('getUrl');
    });

    Route::prefix('Menu')->as('menu.')->group(function () {
        Route::get('/', 'MenuController@index')->name('index');
        Route::get('/create', 'MenuController@create')->name('create');
        Route::post('/store', 'MenuController@store')->name('store');
        Route::get('/edit/{id}', 'MenuController@edit')->name('edit');
        Route::post('/update/{id}', 'MenuController@update')->name('update');
        Route::post('/delete/{id}', 'MenuController@delete')->name('delete');


        Route::prefix('{menuId}/Contents')->as('content.')->group(function () {
            Route::get('/create', 'MenuContentController@create')->name('create');
            Route::post('/store', 'MenuContentController@store')->name('store');
        });

        Route::get('/getUrls', 'MenuContentController@getUrls')->name('getUrls');
    });

    Route::prefix('Form')->as('form.')->group(function () {
        Route::get('/', 'FormController@index')->name('index');
        Route::get('/create', 'FormController@create')->name('create');
        Route::post('/store', 'FormController@store')->name('store');
        Route::get('/edit/{id}', 'FormController@edit')->name('edit');
        Route::post('/update/{id}', 'FormController@update')->name('update');
        Route::post('/delete/{id}', 'FormController@delete')->name('delete');



        Route::prefix('{formId}/Results')->as('result.')->group(function () {
            Route::get('/', 'FormResultController@index')->name('index');
            Route::get('/updateReadStatus', 'FormResultController@updateReadStatus')->name('updateReadStatus');
        });
    });

    Route::prefix('CustomContent')->as('custom_content.')->group(function () {
        Route::get('/', 'CustomContentController@index')->name('index');
        Route::get('/update', 'CustomContentController@update')->name('update');
        Route::get('/search', 'CustomContentController@search')->name('search');
    });


    Route::prefix('Panel')->as('panel.')->group(function () {
        Route::get('/changeLanguage/{code}', 'PanelController@changeLanguage')->name('changeLanguage');
    });
});
