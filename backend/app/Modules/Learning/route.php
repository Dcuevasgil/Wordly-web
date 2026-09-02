<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Modules\Learning\Controllers\UserWordController;
use App\Modules\Learning\Controllers\ExerciseController;
use App\Modules\Learning\Controllers\OnboardingController;
use App\Modules\Learning\Controllers\AssessmentController;

Route::middleware('auth:api')->prefix('learning')->group(function () {

    /* UserWordController */
    Route::get('/review-words', [UserWordController::class, 'reviewWords']);
    Route::post('/add-words', [UserWordController::class, 'addWords']);
    

    /* ExerciseController */
    
    // Obtener todos los ejercicios
    // Me servirá para la parte de admin
    Route::get('/exercises', [ExerciseController::class, 'getExercises']);

    // Obtener ejercicios con un filtrado
    Route::get('/exercises-by-topic', [ExerciseController::class, 'getExercisesByTopic']);

    // Registra el intento de un usuario a un ejercicio y devuelve si acertó
    Route::post('/exercises/attempt', [ExerciseController::class, 'submitAnswer'])->name('exercises.attempt');

    // Al registrarse, le permite al usuario seleccionar su nivel de progreso
    Route::post('/onboarding', [OnboardingController::class, 'createEnrollment']);

    /* AssessmentController */

    // Devuelve los ejercicios del examen de nivel
    Route::get('/assessment', [AssessmentController::class, 'getAssessment']);

    // Recibe las respuestas, calcula el nivel y lo asigna al usuario
    Route::post('/assessment', [AssessmentController::class, 'submitAssessment']);
});
