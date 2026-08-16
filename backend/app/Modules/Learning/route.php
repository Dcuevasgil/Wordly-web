<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Modules\Learning\Controllers\UserWordController;
use App\Modules\Learning\Controllers\ExerciseController;


Route::middleware('auth:api')->prefix('learning')->group(function () {
    /* UserWordController */
    Route::get('/review-words', [UserWordController::class, 'reviewWords']); // -> listo
    Route::post('/add-words', [UserWordController::class, 'addWords']); // -> listo
    

    /* ExerciseController */
    
    // Obtener todos los ejercicios
    // Me servirá para la parte de admin
    Route::get('/exercises', [ExerciseController::class, 'getExercises']); // -> listo

    // Obtener ejercicios con un filtrado
    Route::get('/exercises-by-topic', [ExerciseController::class, 'getExercisesByTopic']);

    // Registra el intento de un usuario a un ejercicio y devuelve si acertó
    Route::post('/exercises/attempt', [ExerciseController::class, 'submitAnswer'])->name('exercises.attempt'); // -> lista
});
