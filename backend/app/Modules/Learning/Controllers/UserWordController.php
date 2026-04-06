<?php

namespace App\Modules\Learning\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

class UserWordController extends Controller {


    /**
     * Endpoint /api/learning/review-words
     * 
     * Método
     * GET
     * 
     * Ruta
     * /api/learning/review-words
     * 
     * Autenticación
     * Bearer Token (JWT)
     * Header:
     * Authorization: Bearer {token}
     * 
     * Parámetros de entrada
     * Ninguno (se obtiene el usuario desde el token)
     * 
     * 
     * Qué debe hacer el endpoint
     * 
     * 1. Obtener el usuario autenticado a partir del token
     * 
     * 2. Buscar en la tabla user_words las palabras del usuario donde:
     *    - next_review <= NOW()
     * 
     * 3. Si el usuario NO tiene palabras en user_words:
     *    - Asignarle palabras iniciales desde la tabla words
     *    - Crear registros en user_words con valores iniciales
     * 
     * 4. Obtener la información necesaria de cada palabra:
     *    - Texto original (words)
     *    - Traducción (translations)
     * 
     * 5. Limitar la cantidad de palabras (ej: 10 palabras por sesión)
     * 
     * 6. Devolver la lista de palabras listas para practicar
     * 
     * 
     * Respuesta esperada
     * 200 OK
     * 
     * {
     *   "message": "Words to review retrieved successfully",
     *   "data": [
     *     {
     *       "id_word": 12,
     *       "word": "house",
     *       "translation": "casa",
     *       "next_review": "2026-04-05 18:00:00"
     *     },
     *     {
     *       "id_word": 25,
     *       "word": "car",
     *       "translation": "coche",
     *       "next_review": "2026-04-05 18:00:00"
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
     * Error interno del servidor
     * 500 Internal Server Error
     * {
     *   "error": "Server error while retrieving words"
     * }
     * 
     */
    public function reviewWords() {

        try {

            // 1. User Authentication
            $user = JWTAuth::parseToken()->authenticate();

            $id_user = $user->id_users;

            // Search pending words
            $words = DB::table('user_words')
                ->join('words', 'user_words.word_id', '=', 'words.id_words')
                ->join('translations', 'words.id_words', '=', 'translations.word_id')
                ->where('user_id', $id_user)
                ->where(function ($query) {
                    $query->where('user_words.next_review', '<=', now())
                        ->orWhereNull('user_words.next_review');
                })
                ->select(
                    'words.id_words as id_word',
                    'words.text as word',
                    'translations.translation',
                    'user_words.next_review'
                )
                ->limit(10)
                ->get();
            
            if ($words->isEmpty()) {
                return response()->json([
                    'message' => 'No words to review',
                    'data' => []
                ], 200);
            }

            return response()->json([
                'message' => 'Words retrieved successfully',
                'data' =>$words
            ]);

        } catch (\Tymon\JwtAuth\Exceptions\JWTException $e) {
            
            return response()->json([
                'error' => 'Unauthorized',
                'detail' => $e->getMessage()
            ], 401);
            
        } catch (\Exception $e) {

            return response()->json([
                'error' => 'Server error while retrieving words'
            ], 500);

        }

    }


    /**
     * Endpoint /api/learning/add-words
     * 
     * Método
     * POST
     * 
     * Ruta
     * /api/learning/add-words
     * 
     * Autenticación
     * Bearer Token (JWT)
     * Header:
     * Authorization: Bearer {token}
     * 
     * Parámetros de entrada (JSON)
     * {
     *   "word": "house",
     *   "origin_language_id": 1,
     *   "target_language_id": 2,
     *   "translation": "casa",
     *   "example": "I live in a big house"
     * }
     * 
     * 
     * Qué debe hacer el endpoint
     * 
     * 1. Obtener el usuario autenticado a partir del token
     * 
     * 2. Validar los datos de entrada:
     *    - word (string, requerido)
     *    - origin_language_id (int, requerido)
     *    - target_language_id (int, requerido)
     *    - translation (string, requerido)
     *    - example (string, opcional)
     * 
     * 3. Verificar que los idiomas existen en la tabla languages:
     *    - origin_language_id
     *    - target_language_id
     * 
     * 4. Comprobar si la palabra ya existe en la tabla words:
     *    - Si existe, reutilizarla
     *    - Si no existe, crear una nueva palabra
     * 
     * 5. Crear la traducción en la tabla translations:
     *    - word_id
     *    - target_language_id
     *    - translation
     *    - example
     * 
     * 6. (Opcional) Asignar la palabra al usuario en la tabla user_words:
     *    - user_id
     *    - word_id
     *    - valores iniciales del sistema de repetición
     * 
     * 7. Devolver la palabra creada junto con su traducción
     * 
     * 
     * Respuesta esperada
     * 201 Created
     * 
     * {
     *   "message": "Word created successfully",
     *   "data": {
     *     "id_word": 45,
     *     "word": "house",
     *     "translation": "casa"
     *   }
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
     * Error de validación
     * 422 Unprocessable Entity
     * {
     *   "error": "Invalid input data"
     * }
     * 
     * 
     * Idioma no encontrado
     * 404 Not Found
     * {
     *   "error": "Language not found"
     * }
     * 
     * 
     * Error interno del servidor
     * 500 Internal Server Error
     * {
     *   "error": "Server error while creating word"
     * }
     */
    public function addWords(Request $request) {

        try {

            // 1. User Authentication
            $user = JWTAuth::parseToken()->authenticate();

            $id_user = $user->id_users;

            // 2. && 3. Validate entry data and verify that languages exists in languages table
            $request->validate([
                'word' => 'required|string',
                'origin_language_id' => 'required|exists:languages,id_languages',
                'target_language_id' => 'required|exists:languages,id_languages',
                'translation' => 'required|string',
                'example' => 'nullable|string',
            ]);


            $wordText = $request->input('word');
            $originLanguageId = $request->input('origin_language_id');
            $targetLanguageId = $request->input('target_language_id');
            $translation = $request->input('translation');
            $translationText = $request->input('translation');
            $example = $request->input('example');
            

            $wordExists = DB::table('words')
                ->where('text', $wordText)
                ->where('origin_language_id', $originLanguageId)
                ->first();
            
            
            // Verify existance of $wordExists
            if ($wordExists) {
                $wordId = $wordExists->id_words;
            } else {
                $wordId = DB::table('words')->insertGetId([
                    'text' => $wordText,
                    'origin_language_id' => $originLanguageId,
                    'register_date' => now(),
                    'updated_date' => now()
                ]);
            }


            $translationExists = DB::table('translations')
                ->where('word_id', $wordId)
                ->where('target_language_id', $targetLanguageId)
                ->where('translation', $translation)
                ->first();

            // Verify existance of $wordExists
            if ($translationExists) {
                $wordId = $wordExists->id_words;
            } else {
                $translation = DB::table('translations')->insert([
                    'word_id' => $wordId,
                    'target_language_id' => $targetLanguageId,
                    'translation' => $translationText,
                    'example' => $example,
                    'register_date' => now(),
                    'updated_date' => now()
                ]);
            }                        

            return response()->json([
                'message' => 'Word created successfully',
                'data' => [
                    'word' => [
                        'id' => $wordId,
                        'text' => $wordText
                    ],
                    'translation' => [
                        'text' => $translationText,
                        'language_id' => $targetLanguageId
                    ]
                ]
            ], 201);

        } catch (\Tymon\JwtAuth\Exceptions\JWTException $e) {
            
            return response()->json([
                'error' => 'Unauthorized',
                'detail' => $e->getMessage()
            ], 401);
            
        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'error' => 'Invalid input data',
                'detail' => $e->errors()
            ], 422);

        } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {

            return response()->json([
                'error' => 'Language not found'
            ], 404);

        } catch (\Exception $e) {

            return response()->json([
                'error' => 'Server error while creating word',
                'detail' => $e->getMessage(),  // añade esta línea
                'line' => $e->getLine(),       // y esta
                'file' => $e->getFile()        // y esta
            ], 500);

        }
        
    }






}