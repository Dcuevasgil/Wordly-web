<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject {

    protected $table = 'users';
    protected $primaryKey = 'id_users';
    
    // const TIMESTAMPS_REGISTER_DATE = 'register_date';
    // const TIMESTAMPS_UPDATE_DATE = 'update_date';


    protected $fillable = [
        'name',
        'email',
        'role',
        'is_user_active',
        'last_access'
    ];

    // Aqui solo password o más campos?
    // Yo creo que más campos pero ahora mismo no estoy 100% seguro
    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'register_date' => 'datetime',
            'update_date' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * 
     * Esto que esta aqui es un hook del modelo en Eloquent
     * 
     * Mas concretamente:
     *      - Metodo que se ejecuta automaticamente cuando el modelo "arranca"
     *      - Y dentro defino eventos del ciclo de vida del modelo
     * 
     * ¿Qué es booted()?
     * 
     * Es un método especial de Laravel que se ejecuta cuando el modelo se inicializa
     * 
     * Dentro de este metodo puedo enganchar eventos como
     * 1. creating
     * 2. created
     * 3. updating
     * 4. updated
     * 5. deleting
     * 6. etc
     * 
     * 
     * 🧠 ¿Qué hace mi codigo exactamente?
     * 
     * 1️⃣ Cuando se está creando un registro:
     *      - static::creating(function ($fecha) {
     * 
     * Antes de que se inserte en la base de datos
     *      - $fecha-> register_date = $fecha->register_date ?? now();
     *      - $fecha->update_date = $fecha->update_date ?? now();
     * 
     * Si no tiene valor -> les mete now()
     * 
     * Es decir:
     *  * Autogestiono mis propios timestamps personalizados
     *  * No uso created_at / updated_at
     * 
     * 
     * 2️⃣ Cuando se actualiza un registro
     * static::updating(function ($fecha) {
     *       $fecha->update_date = now();
     * });
     *
     * 
     * Cada vez que hago update:
     *      - Fuerzo que la fecha de actualizacion sea de ahora
     * 
     * 
     * 🎯 En resumen
     * 
     * Es una forma manual de:
     * 1. Controlar timestamps personalizados
     * 2. Sin usar las convenciones por defecto de Laravel
     * 3. Sin usar CREATED_AT / UPDATED_AT
     * 
     * 
     * @return void
    */
    // protected static function booted()
    // {
    //     static::creating(function ($fecha) {
    //         $fecha-> register_date = $fecha->register_date ?? now();
    //         $fecha->update_date = $fecha->update_date ?? now();
    //     });

    //     static::updating(function ($fecha) {
    //         $fecha->update_date = now();
    //     });
    // }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
