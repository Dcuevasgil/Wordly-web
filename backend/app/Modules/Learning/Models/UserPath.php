<?php

namespace App\Modules\Learning\Models;

use Illuminate\Database\Eloquent\Model;

use App\Modules\Auth\Models\User;
use App\Modules\Learning\Models\LearningPath;

class UserPath extends Model
{
    
    protected $table = 'user_paths';
    protected $primaryKey = 'id_user_paths';
    public $timestamps = false;


    protected $fillable = [
        'user_id',
        'learning_path_id',
        'level',
        'self_assessment',
        'is_active',
        'progress_percentage',
        'last_access_date',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'last_access_date' => 'datetime'
    ];


    // Relaciones con las tablas

    // User
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id_users');
    }

    // Learning path
    public function learningPath() {
        return $this->belongsTo(LearningPath::class, 'learning_path_id', 'id_learning_paths');
    }


}
