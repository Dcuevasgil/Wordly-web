<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Modules\Learning\Controllers\UserWordController;
use App\Modules\Learning\Controllers\ExerciseController;


Route::middleware('auth:api')->prefix('learning')->group(function () {
    /* UserWordController */
    Route::get('/learning/review-words', [UserWordController::class, 'reviewWords']);
    Route::post('/learning/add-words', [UserWordController::class, 'addWords']);

    /* ExerciseController */
    
    // Obtener todos los ejercicios
    // Me servirá para la parte de admin
    Route::get('/exercises', [ExerciseController::class, 'getExercises']);

    // Obtener ejercicios con un filtrado
    Route::get('/exercisesByTopic', [ExerciseController::class, 'getExercisesByTopic']);
});
