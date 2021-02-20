<?php
Route::get('/sitemap.xml', 'SitemapXmlController@index');

Route::fallback("WebController@index");
