<?php

Route::get('/', 'DashboardController@index')->name('dashboard');


Route::prefix('Form')->group(function () {
     Route::get('/', 'FormController@index')->name('form.index');
     Route::get('/create', 'FormController@create')->name('form.create');
     Route::post('/store', 'FormController@store')->name('form.store');
     Route::get('/edit/{id}', 'FormController@edit')->name('form.edit');
     Route::post('/update/{id}', 'FormController@update')->name('form.update');
     Route::post('/delete/{id}', 'FormController@delete')->name('form.delete');
});
