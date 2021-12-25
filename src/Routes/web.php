<?php

use Dawnstar\Core\Http\Controllers\WebController;
use Dawnstar\Core\Http\Controllers\FormMessageController;

Route::post('/form/{form}', [FormMessageController::class, 'store'])->name('form_store');
Route::fallback([WebController::class, 'index']);
