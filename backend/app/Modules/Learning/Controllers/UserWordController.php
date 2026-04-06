<?php

namespace App\Modules\Learning\Controllers;

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
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Unauthorized',
                'detail' => $e->getMessage()
            ], 401);
        }

        $id_user = $user->id_users;

        // Buscar palabras a revisar del usuario
        $words = DB::table('user_words')
            ->where('user_id', $id_user)
            ->where(function ($query) {
                $query->where('next_review', '<=', now())
                    ->orWhereNull('next_review');
            })
            ->limit(10)
            ->get();

        // ✅ pluck FUERA del foreach, y sin la línea $words->id_words
        $id_words = $words->pluck('word_id');

        if ($words->isEmpty()) {
            return response()->json([
                'message' => 'No words to review',
                'data' => []
            ]);
        }

        // Obtener info de cada palabra desde la tabla words
        $info_from_each_word = DB::table('words')
            ->whereIn('id_words', $id_words)
            ->get();

        return response()->json([
            'message' => 'Words retrieved successfully',
            'data' => $info_from_each_word
        ]);
    }

}