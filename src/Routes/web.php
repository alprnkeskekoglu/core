<?php

Route::get('/sitemap.xml', 'SitemapXmlController@index')->name('sitemap_xml');
Route::fallback("WebController@index");
