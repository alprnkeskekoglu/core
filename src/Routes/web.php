<?php

use Dawnstar\Core\Http\Controllers\WebController;
use Dawnstar\Core\Http\Controllers\FormMessageController;
use Dawnstar\Core\Http\Controllers\SitemapXmlController;

Route::get('/sitemap.xml', [SitemapXmlController::class, 'index'])->name('sitemap_xml');
Route::post('/form/{form}', [FormMessageController::class, 'store'])->name('form_store');
Route::fallback([WebController::class, 'index']);
