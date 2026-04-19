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