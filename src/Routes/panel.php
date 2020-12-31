<?php

Route::get('/', 'DashboardController@index')->name('dashboard');


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
