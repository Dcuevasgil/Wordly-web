<?php

use Illuminate\Support\Facades\Route; 


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