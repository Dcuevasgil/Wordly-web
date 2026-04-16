<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Modules\Learning\Controllers\UserWordController;


Route::middleware('auth:api')->group(function () {
    Route::get('/learning/review-words', [UserWordController::class, 'reviewWords']);
    Route::post('/learning/add-words', [UserWordController::class, 'addWords']);
});
