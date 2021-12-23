<?php

use Dawnstar\Http\Controllers\WebController;
use Dawnstar\Http\Controllers\FormMessageController;

Route::post('/form/{form}', [FormMessageController::class, 'store'])->name('form_store');
Route::fallback([WebController::class, 'index']);
