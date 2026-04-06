<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Modules\Learning\Controllers\UserWordController;

Route::get('/learning/review-words', [UserWordController::class, 'reviewWords'])
    ->middleware('auth:api');