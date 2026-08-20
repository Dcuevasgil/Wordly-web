<?php

namespace App\Modules\Learning\Models;

use Illuminate\Database\Eloquent\Model;

class LearningPath extends Model
{
    
    protected $table = 'learning_paths';
    protected $primaryKey = 'id_learning_paths';
    public $timestamps = false;

    protected $fillable = [
        'code',
        'name',
        'description'
    ];

    // Relaciones con los modelos

    // User Path
    public function userPaths() {
        return $this->hasMany(UserPath::class, 'learning_path_id', 'id_learning_paths');
    }
}
