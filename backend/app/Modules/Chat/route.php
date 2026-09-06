<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Modules\Chat\Controllers\ChatController;


Route::prefix('chat')->middleware('auth:api')->group(function () {

    Route::post('/message', [ChatController::class, 'sendMessage'])->middleware('throttle:20,1');

});
