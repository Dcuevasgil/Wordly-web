<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{


    /**
     * Enpoint /api/register
     * 
     * Método
     * POST
     * 
     * Ruta
     * /api/register
     * 
     * Parámetros de entrada
     * Body (JSON)
     * {
     *  "name": "Test2",
     *  "email": "test2@test.com",
     *  "password": "password1234"
     * }
     * 
     * 
     * Campos minimos para el registro:
     * 
     * 1. name (string)
     * 2. email (string)
     * 3. password (string)
     * 
     * Qué debe hacer el endpoint
     * 1. Recibir los datos del usuario
     * 2. Validar campos obligatorios
     * 3. Crear el usuario en la base de datos
     * 4. Hashear la contraseña
     * 5. Generar el token
     * 6. Devolver el usuario + el token
     * 
     * 
     * Respuesta esperada
     * {
     *   "message": "User correctly registered",
     *   "data": {
     *       "id_users": 2,
     *       "name": "Test2",
     *       "email": "test2@test.com",
     *       "role": "user",
     *       "is_user_active": true,
     *       "register_date": "2026-03-10T11:43:55.000000Z",
     *       "updated_date": "2026-03-10T11:43:55.000000Z"
     *   },
     *   "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.*    eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL3JlZ2lzdGVyIiwiaWF0IjoxNzczMTQzMDM4LCJleHAiOjE3NzMxNDY2MzgsIm5iZiI6MTc3MzE0MzAzOCwianRpIjoiMndmUW9wWTBUY2NXS3BudyIsInN1YiI6IjIiLCJwcnYiOiIyM2JkNWM4OT * }
     *  
     * Posibles errores
     * Campos faltantes
     * 400 Bad Request
     * {
     *   "error": "Missing required fields"
     * }
     * 
     * 
     * Email ya registrado
     * 409 Conflict
     * {
     *   "error": "Email already registered"
     * }
     *  
     */

    public function register(Request $request) {


        // Validar variables de entrada
        $data = $request->only([
            'name',
            'email',
            'password'
        ]);


        // Validaciones previas
        $name = $data['name'] ?? null;
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        // Datos del usuario opcionales
        $role = $data['role'] ?? null;
        $is_user_active = $data['is_user_active'] ?? 0;
        // $last_access = $data['last_access'] ?? null;

        // Datos de las fechas
        $register_date = now();
        $updated_date = now();
        
        

        // Intento de entrada
        $user = new User();

        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        // $user->$email;
        // $user->$password;

        // Datos opcionales
        $user->role = 'user';
        $user->is_user_active = true;
        // $user->$last_access;

        // Fechas (dentro de Datos opcionales)

        // como no hacen nada aqui los comento
        $user->register_date = $register_date;
        $user->updated_date = $updated_date; 


        $user->save();
        
        // Devolver token y usuario registrado
        $user_token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'User correctly registered',
            'data' => [
                
                'id_users' => $user->id_users,
                
                'name' => $user->name,
                
                'email' => $user->email,
                
                'role' => $user->role,
                
                'is_user_active' => $user->is_user_active,
                
                'register_date' => $user->register_date,
                'updated_date' => $user->updated_date,
            
            ],

            'token' => $user_token,
        
        ], 201);

    }

    // Prueba del metodo register
    // public function register(Request $request)
    // {

    //     $data = $request->only([
    //         'name',
    //         'email',
    //         'password'
    //     ]);

        

    //     if (!$name || !$email || !$password) {
    //         return response()->json([
    //             'error' => 'Missing required fields'
    //         ], 400);
    //     }

    //     $user = new User();

    //     $user->name = $name;
    //     $user->email = $email;
    //     $user->password = $password; // Laravel lo hashea solo

    //     $user->save();


    //     $user_token = JWTAuth::fromUser($user);

    //     return response()->json([
    //         'message' => 'Registro correcto',
    //         'data' => [
    //             'id_users' => $user->id_users,
    //             'name' => $user->name,
    //             'email' => $user->email,
    //             'password' => $user->$password,
    //             'role' => $user->role,
    //             'is_user_active' => $user->is_user_active,
    //             'register_date' => $user->register_date,
    //             'update_date' => $user->update_date,
    //         ],
    //         'token' => $user_token,
    //     ], 201);
    // }



    /**
     * 
     * Endpoint /api/login
     * 
     * Método
     * POST
     * 
     * Ruta
     * /api/login
     * 
     * Parámetros de entrada
     * Body (JSON)
     * {
     *   "email": "test2@test.com",
     *   "password": "password1234"
     * }
     * 
     * 
     * Campos minimos para el login:
     * 
     * 1. email (string)
     * 2. password (string)
     * 3. confirm password (validacion si es == a la password original, solo en frontend)
     * 
     * 
     * 
     * Qué debe hacer el endpoint
     * 1. Recibir credenciales del usuario registrado
     * 2. Buscar el campo del usuario por el email
     * 3. Verificar que la contraseña sea correcta
     * 4. Generar el token
     * 5. Devolver el token + los datos del usuario logueado
     * 
     * Respuesta esperada
     * {
         * "message": "User correctly logged in",
         * "data": {
         *    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.     * eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNzczMTQzMDY2LCJleHAiOjE3NzMxNDY2NjYsIm5iZiI6MTc3MzE0MzA2NiwianRpIjoiTTFFQXcxQ05sNW51NFk1ZCIsInN1YiI6IjIiLCJwcnYiOiIyM2JkNWM4OT     *Q5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.Oh_ywRAtEAfWhgRDKTBbfBLciy6tu3F9oEq2_necNCw",
         *    "token_type": "bearer",
         *    "expires_in": 3600,
         *    "user": {
         *        "id_users": 2,
         *        "name": "Test2",
         *        "email": "test2@test.com",
         *        "role": "user",
         *        "is_user_active": 1,
         *        "last_access": null,
         *        "register_date": "2026-03-10T11:43:55.000000Z",
         *        "updated_date": "2026-03-10T11:43:55.000000Z"
         *    }
         * }
     * }
     * 
     * 
     * 
     */


    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required','email'],
            'password' => ['required','string'],
        ]);

        $credentials = ['email' => $data['email'], 'password' => $data['password']];

        if (!$user_token = auth('api')->attempt($credentials)) {
            
            return response()->json(['error' => 'Invalid credentials'], 401);
        
        }

        $limitTime = config('jwt.ttl');

        return response()->json([

            'message' => 'User correctly logged in',
            'data' => [
                'access_token' => $user_token,
                
                'token_type' => 'bearer',
                
                'expires_in' => $limitTime * 60,
                
                'user' => auth('api')->user(),
            ]
        
        ]);
    }



    /**
     * ----------------------------------------------------------
     * Endpoint: GET /api/me
     * ----------------------------------------------------------
     *
     * Devuelve la información del usuario actualmente autenticado.
     *
     * Este endpoint se utiliza para:
     * - Obtener los datos del perfil del usuario
     * - Verificar si el token actual del usuario logueado es válido
     * - Mantener sesión en el frontend
     *
     * ----------------------------------------------------------
     * Método HTTP
     * ----------------------------------------------------------
     * GET
     *
     * ----------------------------------------------------------
     * Ruta
     * ----------------------------------------------------------
     * /api/me
     *
     * ----------------------------------------------------------
     * Parámetros de entrada
     * ----------------------------------------------------------
     * Ninguno en el body.
     *
     * El único dato necesario es el token JWT enviado en el header:
     *
     * Authorization: Bearer <JWT_TOKEN>
     *
     * ----------------------------------------------------------
     * Qué hace el endpoint
     * ----------------------------------------------------------
     * 1. Lee el token JWT enviado en la petición
     * 2. Valida el token
     * 3. Obtiene el usuario autenticado
     * 4. Devuelve sus datos de perfil
     *
     * ----------------------------------------------------------
     * Respuesta esperada
     * ----------------------------------------------------------
     * {
     *   "id_users": 1,
     *   "name": "David",
     *   "email": "david@email.com",
     *   "role": "user",
     *   "is_user_active": true,
     *   "last_access": null,
     *   "register_date": "2026-03-06T12:00:00",
     *   "updated_date": "2026-03-06T12:00:00"
     * }
     *
     * ----------------------------------------------------------
     * Posibles errores
     * ----------------------------------------------------------
     *
     * 401 Unauthorized
     *
     * {
     *   "message": "Token not provided"
     * }
     *
     * o
     *
     * {
     *   "message": "Invalid token"
     * }
     *
     * ----------------------------------------------------------
     * Nota de arquitectura Wordly
     * ----------------------------------------------------------
     * Este endpoint no recibe parámetros porque
     * el usuario ya viene identificado dentro del JWT.
    */

    public function me() {
        $user = auth('api')->user();
               
        
        return response()->json([
            'data' => $user       
        ]);
    }


    /**
     * ----------------------------------------------------------
     * Endpoint: POST /api/logout
     * ----------------------------------------------------------
     *
     * Cierra la sesión del usuario actualmente autenticado
     * invalidando su token JWT.
     *
     * Este endpoint se utiliza para:
     * - Cerrar la sesión del usuario
     * - Invalidar el token JWT actual
     * - Añadir el token a la blacklist para evitar su reutilización
     *
     * ----------------------------------------------------------
     * Método HTTP
     * ----------------------------------------------------------
     * POST
     *
     * ----------------------------------------------------------
     * Ruta
     * ----------------------------------------------------------
     * /api/logout
     *
     * ----------------------------------------------------------
     * Parámetros de entrada
     * ----------------------------------------------------------
     * Ninguno en el body.
     *
     * El único dato necesario es el token JWT enviado en el header:
     *
     * Authorization: Bearer <JWT_TOKEN>
     *
     * ----------------------------------------------------------
     * Qué hace el endpoint
     * ----------------------------------------------------------
     * 1. Lee el token JWT enviado en la petición
     * 2. Valida el token
     * 3. Invalida el token actual
     * 4. Añade el token a la blacklist
     * 5. Devuelve confirmación de cierre de sesión
     *
     * ----------------------------------------------------------
     * Respuesta esperada
     * ----------------------------------------------------------
     * {
     *   "message": "Successfully logged out"
     * }
     *
     * ----------------------------------------------------------
     * Posibles errores
     * ----------------------------------------------------------
     *
     * 401 Unauthorized
     *
     * {
     *   "message": "Token not provided" (Unauthenticated)
     * }
     *
     * o
     *
     * {
     *   "message": "Invalid token"
     * }
     * 
     * ----------------------------------------------------------
     * Nota de arquitectura Wordly
     * ----------------------------------------------------------
     * Este endpoint invalida el token actual del usuario
     * para impedir que vuelva a utilizarse en futuras
     * peticiones a la API.
     */
    public function logout() {
        auth('api')->user();
               
        
        return response()->json([
            'message' => 'User correctly logout'
        ]);
    }

}
