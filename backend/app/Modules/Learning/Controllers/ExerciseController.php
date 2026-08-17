<?php

namespace App\Modules\Learning\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

use App\Modules\Learning\Models\Exercise;

use App\Http\Controllers\Controller;

use App\Modules\Learning\Requests\SubmitExerciseAnswerRequest;
use App\Modules\Learning\Services\ExerciseAttemptService;

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
     *    - type (formato: single-choice / fill-blank)
     *    - topic (tema concreto: past-simple, plurals, ...)
     *    - options (todas las opciones de respuesta con su id)
     * 
     *    IMPORTANTE: no se envían ni las respuestas correctas ni la explicación. Ambas revelarían la solución antes de responder. Viajan en la respuesta de POST /exercises/attempt
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
     *       "id": 11,
     *       "question": "¿Cuál es el paso simple de \"go\"?",
     *       "type": single-choice,
     *       "topic": "past-simple",
     *       "options": [
     *         { "id": 41, "answer": "went" },
     *         { "id": 42, "answer": "goed" },
     *         { "id": 43, "answer": "gone" },
     *         { "id": 44, "answer": "going" },
     *       ],
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
            
            // 6. Si no hay resultados
            if ($exercises->isEmpty()) {
                return response()->json([
                    'error' => 'No exercises found for the specified topic'
                ], 404);
            }

            // 7. Transformar datos
            $data = $exercises->map(fn ($exercise) => $this->formatExercise($exercise));

            // 8. Respuesta final
            return response()->json([
                'message' => 'Exercises retrieved successfully',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'error' => 'Server error while retrieving exercises',
                'message' => $e->getMessage()
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
     *       "id": 11,
     *       "question": "¿Cuál es el paso simple de \"go\"?",
     *       "type": single-choice,
     *       "topic": "past-simple",
     *       "options": [
     *         { "id": 41, "answer": "went" },
     *         { "id": 42, "answer": "goed" },
     *         { "id": 43, "answer": "gone" },
     *         { "id": 44, "answer": "going" },
     *       ],
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
            $data = $exercises->map(fn ($exercise) => $this->formatExercise($exercise));
                
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


    /**
     * Endpoint /api/learning/exercises/attempt
     * 
     * Método
     * POST
     * 
     * Ruta
     * /api/learning/exercises/attempt
     * 
     * Autenticación
     * Bearer Token (JWT)
     * Header
     * Authorization: Bearer {token}
     * 
     * Parámetros de entrada
     * Body (JSON)
     * - exercise_id (int, requerido) -> ejercicio respondido
     * - user_responses (array de strings, requerido) -> respuestas del usuario.
     * Hoy contiene un único elemento. El formato array permite ejercicios en cascada (multipaso) sin cambiar el contrato.
     * Ejemplo: ["FUTURE"] -> en el futuro: ["FUTURE", "BE GOING TO"]
     * - exercise_answer_id (int, opcional) -> id de la opción pulsada.
     * Null en ejercicios de texto libre (fill-blank).
     * - response_time_ms (int, requerido) -> tiempo de respuesta en milisegundos
     * 
     * Ejemplo de petición
     * {
     *   "exercise_id": 1,
     *   "user_responses": ["I am going to study tonight"],
     *   "exercise_answer_id": 3,
     *   "response_time_ms": 4820
     * }
     * 
     * 
     * Qué debe hacer el endpoint
     * 
     * 1. Obtener el usuario autenticado a partir del token (nunca se acepta user_id desde el cliente)
     * 
     * 2. Validar el payload mediante SubmitExerciseAnswerRequest
     * 
     * 3. Cargar el ejercicio junto con sus respuestas posibles (relación answers -> tabla exercise_answers)
     * 
     * 4. Normalizar la respuesta del usuario y las respuestas correctas (trim + minúsculas) para evitar falsos negativos por mayúsculas o espacios sobrantes
     * 
     * 5. Comparar y determinar si la respuesta es correcta
     * 
     * 6. Registrar el intento en exercise_attempts:
     * - user_response se guarda como JSON del array recibido
     * - attempt_date la genera el servidor, nunca el cliente
     * - is_user_response_correct se calcula, nunca llega del frontend
     * 
     * 7. Devolver el resultado para que el frontend pinte el feedback
     * 
     * 
     * Respuesta esperada
     * 201 Created
     * 
     * {
     *   "is_correct": false,
     *   "attempt_id": 42,
     *   "response_time_ms": 4820,
     *   "explanation": "\"go\" es un verbo irregular, su pasado es \"went\".",
     *   "correct_answers": ["went"]
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
     * Datos de entrada inválidos
     * 422 Unprocessable Entity
     * 
     * {
     *   "message": "The given data was invalid."
     *   "errors": {
     *     "user_responses": ["You must submit at least one answer."]
     *   }
     * }
     * 
     * 
     * El ejercicio indicado no existe
     * 404 Not found
     * 
     * {
     *   "error": "The especified exercise does not exist"
     * }
     * 
     * Error interno del servidor
     * 500 Internal Server Error
     * 
     * {
     *   "Server error while saving the exercise attempt"
     * }
     */

    public function submitAnswer(SubmitExerciseAnswerRequest $request, ExerciseAttemptService $service) {
        
        $result = $service->submitAnswer($request->validated(), $request->user()->getKey());

        $attempt = $result['attempt'];
        $exercise = $result['exercise'];

        return response()->json([
            'is_correct' => $attempt->is_user_response_correct,
            'attempt_id' => $attempt->id_exercise_attempts,
            'explanation' => $exercise->explanation,
            'correct_answers' => $exercise->answers->where('is_correct_answer', true)->pluck('answer'),
        ], 201);
    }



    /**
     * Formats an exercise for the API response.
     * Correct answers and explanations are deliberately excluded.
     */
    private function formatExercise(Exercise $exercise): array {
        return [
            'id' => $exercise->id_exercises,
            'question' => $exercise->question,
            'type' => $exercise->type_exercise,
            'topic' => $exercise->topic_exercise,
            'options' => $exercise->answers->shuffle()->map(function ($answer) {
                return [
                    'id' => $answer->id_exercise_answers,
                    'answer' => $answer->answer,
                ];
            })->values(),
        ];
    }

}