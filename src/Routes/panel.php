<?php

use Dawnstar\Http\Controllers\WebsiteController;


Route::resource('websites', WebsiteController::class)->except(['show']);
