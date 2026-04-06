<?php

use Illuminate\Support\Facades\Route; 

use App\Modules\Auth\Controllers\AuthController;

/*
 |----------------------------------------------------------
 | Test API Endpoint
 | Used to verify backend connectivity
 |----------------------------------------------------------
*/
Route::get('/ping', function () {
    return response()->json([
        'message' => 'API working'
    ]);
});

/**
 * ----------------------------------------------------------
 * Authentification Endpoint
 * Used to authenticate users 
 * 
 * Public authentication routes
 */


Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);


/**
 * Protected routes (JWT required)
 */

Route::middleware('auth:api')->group(function () {

    Route::get('/me', [AuthController::class, 'me']);

    Route::post('/logout', [AuthController::class, 'logout']);
});
