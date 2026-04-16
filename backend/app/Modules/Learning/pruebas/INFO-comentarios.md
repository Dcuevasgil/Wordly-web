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