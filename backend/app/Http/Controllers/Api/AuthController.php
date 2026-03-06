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
     * Campos minimos para el registro:
     * 
     * 1. name
     * 2. email
     * 3. password
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
     * Campos minimos para el login:
     * 
     * 1. email
     * 2. password
     * 3. confirm password (validacion si es == a la password original)
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




    public function me() {

        return response()->json(auth()->user());

    }




}
