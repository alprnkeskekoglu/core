<?php

use Dawnstar\Http\Controllers\WebController;

Route::fallback([WebController::class, 'index']);
