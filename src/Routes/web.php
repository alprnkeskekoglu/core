<?php

Route::get('/sitemap.xml', 'SitemapXmlController@index')->name('sitemap_xml');
Route::post('/formStore/{form}', 'FormResultController@store')->name('form_store');
Route::fallback("WebController@index");
