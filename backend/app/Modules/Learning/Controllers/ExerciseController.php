<?php

namespace App\Modules\Learning\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

use App\Modules\Learning\Models\Exercise;

use App\Http\Controllers\Controller;

class ExerciseController extends Controller {


    /**
     * Endpoint /api/learning/exercises
     * 
     * Método
     * GET
     * 
     * Ruta
     * /api/learning/exercises
     * 
     * Autenticación
     * Bearer Token (JWT)
     * Header:
     * Authorization: Bearer {token}
     * 
     * Parámetros de entrada
     * Query params (opcionales):
     * - topic (string) → filtrar ejercicios por tema
     *   Ejemplo: /api/learning/exercises?topic=future-going-to
     * 
     * 
     * Qué debe hacer el endpoint
     * 
     * 1. Obtener el usuario autenticado a partir del token
     * 
     * 2. Validar si se ha recibido el parámetro 'topic'
     * 
     * 3. Si se recibe 'topic':
     *    - Filtrar los ejercicios por ese tema
     * 
     * 4. Si NO se recibe 'topic':
     *    - Obtener ejercicios en base al contexto del usuario:
     *        - Tema activo (learning_path / user_path)
     *        - Progreso actual
     * 
     * 5. Limitar la cantidad de ejercicios (ej: 5–10 por sesión)
     * 
     * 6. Obtener la información necesaria de cada ejercicio:
     *    - id
     *    - question (frase a traducir)
     *    - correct_answers (array de respuestas válidas)
     *    - explanation (explicación del ejercicio)
     *    - topic (tema)
     * 
     * 7. (Opcional - nivel pro)
     *    - Priorizar ejercicios en base a:
     *        - errores previos del usuario
     *        - dificultad
     *        - spaced repetition (más adelante)
     * 
     * 8. Devolver la lista de ejercicios lista para practicar
     * 
     * 
     * Respuesta esperada
     * 200 OK
     * 
     * {
     *   "message": "Exercises retrieved successfully",
     *   "data": [
     *     {
     *       "id": 1,
     *       "question": "Voy a estudiar esta noche",
     *       "correct_answers": [
     *         "I am going to study tonight",
     *         "I'm going to study tonight"
     *       ],
     *       "explanation": "Se usa 'going to' porque es un plan decidido.",
     *       "topic": "future-going-to"
     *     },
     *     {
     *       "id": 2,
     *       "question": "Creo que lloverá",
     *       "correct_answers": [
     *         "I think it will rain"
     *       ],
     *       "explanation": "Se usa 'will' porque es una opinión.",
     *       "topic": "future-will"
     *     }
     *   ]
     * }
     * 
     * 
     * Posibles errores
     * 
     * Usuario no autenticado
     * 401 Unauthorized
     * {
     *   "error": "Unauthorized"
     * }
     * 
     * 
     * No se encuentran ejercicios para el tema indicado
     * 404 Not Found
     * {
     *   "error": "No exercises found for the specified topic"
     * }
     * 
     * 
     * Error interno del servidor
     * 500 Internal Server Error
     * {
     *   "error": "Server error while retrieving exercises"
     * }
     * 
     */
    public function getExercises(Request $request)
    {
        try {
            // 1. Obtener usuario autenticado
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'error' => 'Unauthorized'
                ], 401);
            }

            // 2. Obtener y validar topic
            $topic = $request->query('topic');

            if ($topic !== null && trim($topic) === '') {
                return response()->json([
                    'error' => 'Invalid topic'
                ], 400);
            }

            // 3. Query base con respuestas
            $query = Exercise::with('answers');

            // 4. Filtrar por topic si existe
            if ($topic) {
                $query->where('topic_exercise', $topic);
            } else {
                // ⚠️ fallback simple (luego lo mejoras con user_path)
                // ahora mismo devolvemos ejercicios generales
            }

            // 5. Limitar resultados
            $exercises = $query->inRandomOrder()
                ->limit(10)
                ->get();
            
            Log::info('Total exercises in DB: ' . Exercise::count());

            Log::info('Query SQL: ' . $query->toSql());

            // 6. Si no hay resultados
            if ($exercises->isEmpty()) {
                return response()->json([
                    'error' => 'No exercises found for the specified topic'
                ], 404);
            }

            // 7. Transformar datos (IMPORTANTE)
            $data = $exercises->map(function ($exercise) {
                return [
                    'id' => $exercise->id_exercises,
                    'question' => $exercise->question,
                    'correct_answers' => $exercise->answers
                        ->where('is_correct_answer', true)
                        ->pluck('answer')
                        ->values(),
                    'explanation' => $exercise->explanation,
                    'topic' => $exercise->topic_exercise,
                    'type' => $exercise->type_exercise
                ];
            });

            // 8. Respuesta final
            return response()->json([
                'message' => 'Exercises retrieved successfully',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'error' => 'Server error while retrieving exercises',
                'message' => $e->getMessage() // quítalo en producción
            ], 500);
        }
    }


    /**
     * Endpoint /api/learning/exercises-by-topic
     * 
     * Método
     * GET
     * 
     * Ruta
     * /api/learning/exercises-by-topic
     * 
     * Autenticación
     * Bearer Token (JWT)
     * Header:
     * Authorization: Bearer {token}
     * 
     * Parámetros de entrada
     * Query params (obligatorio):
     * - topic (string) → filtrar ejercicios por tema
     *   Ejemplo: /api/learning/exercises-by-topic?topic=future-going-to
     * 
     * 
     * Qué debe hacer el endpoint
     * 
     * 1. Obtener el usuario autenticado a partir del token
     * 
     * 2. Validar que el parámetro 'topic' ha sido enviado
     *    - No puede ser null
     *    - No puede estar vacío
     * 
     * 3. Filtrar los ejercicios por el tema indicado ('topic')
     * 
     * 4. Limitar la cantidad de ejercicios (ej: 5–10 por sesión)
     * 
     * 5. Obtener la información necesaria de cada ejercicio:
     *    - id
     *    - question (frase a traducir)
     *    - correct_answers (array de respuestas válidas)
     *    - explanation (explicación del ejercicio)
     *    - topic (tema)
     * 
     * 6. Devolver la lista de ejercicios lista para practicar
     * 
     * 
     * Respuesta esperada
     * 200 OK
     * 
     * {
     *   "message": "Exercises retrieved successfully",
     *   "data": [
     *     {
     *       "id": 1,
     *       "question": "Voy a estudiar esta noche",
     *       "correct_answers": [
     *         "I am going to study tonight",
     *         "I'm going to study tonight"
     *       ],
     *       "explanation": "Se usa 'going to' porque es un plan decidido.",
     *       "topic": "future-going-to"
     *     }
     *   ]
     * }
     * 
     * 
     * Posibles errores
     * 
     * Usuario no autenticado
     * 401 Unauthorized
     * {
     *   "error": "Unauthorized"
     * }
     * 
     * 
     * Parámetro 'topic' no enviado o inválido
     * 400 Bad Request
     * {
     *   "error": "Topic is required"
     * }
     * 
     * 
     * No se encuentran ejercicios para el tema indicado
     * 404 Not Found
     * {
     *   "error": "No exercises found for the specified topic"
     * }
     * 
     * 
     * Error interno del servidor
     * 500 Internal Server Error
     * {
     *   "error": "Server error while retrieving exercises"
     * }
     * 
     */
    public function getExercisesByTopic(Request $request)
    {
        try {
            // 1. Obtener usuario autenticado
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'error' => 'Unauthorized'
                ], 401);
            }

            // 2. Obtener y validar topic (OBLIGATORIO)
            $topic = $request->query('topic');

            if (!$topic || trim($topic) === '') {
                return response()->json([
                    'error' => 'Topic is required'
                ], 400);
            }

            // 3. Obtener ejercicios filtrados por topic
            $exercises = Exercise::with('answers')
                ->where('topic_exercise', $topic)
                ->inRandomOrder()
                ->limit(10)
                ->get();

            // 4. Si no hay resultados
            if ($exercises->isEmpty()) {
                return response()->json([
                    'error' => 'No exercises found for the specified topic'
                ], 404);
            }

            // 5. Transformar datos
            $data = $exercises->map(function ($exercise) {
                return [
                    'id' => $exercise->id_exercises,
                    'question' => $exercise->question,
                    'correct_answers' => $exercise->answers
                        ->where('is_correct_answer', true)
                        ->pluck('answer')
                        ->values(),
                    'explanation' => $exercise->explanation,
                    'topic' => $exercise->topic_exercise
                ];
            });

            // 6. Respuesta final
            return response()->json([
                'message' => 'Exercises retrieved successfully',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Server error while retrieving exercises',
                'message' => $e->getMessage() // quitar en producción
            ], 500);
        }
    }






}