<?php

use Illuminate\Support\Facades\Route; 

use App\Http\Controllers\Api\AuthController;


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
 */
Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);
