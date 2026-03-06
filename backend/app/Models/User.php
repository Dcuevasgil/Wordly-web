<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject {

    protected $table = 'users';
    protected $primaryKey = 'id_users';
    
    const CREATED_AT = 'register_date';
    const UPDATED_AT = 'updated_date';
    public $timestamps = true;


    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_user_active',
        'last_access'
    ];

    
    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'register_date' => 'datetime',
        'update_date' => 'datetime',
        'password' => 'hashed',
    ];
    
    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
