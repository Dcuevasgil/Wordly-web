<?php

namespace App\Modules\Auth\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Modules\Learning\Models\UserPath;

use Tymon\JWTAuth\Contracts\JWTSubject;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable implements JWTSubject {

    use HasFactory;

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
    
    
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

    // Factory
    protected static function newFactory() {
        return \Database\Factories\UserFactory::new();
    }

    // Relaciones con los modelos

    // Learning path y user path
    public function paths() {
        return $this->hasMany(UserPath::class, 'user_id', 'id_users');
    }
}
