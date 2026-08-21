<?php

namespace App\Modules\Learning\Models;

use Illuminate\Database\Eloquent\Model;

use App\Modules\Learning\Models\ExerciseAnswer;

class Exercise extends Model {

    protected $table = 'exercises';
    protected $primaryKey = 'id_exercises';

    
    const CREATED_AT = 'register_date';
    const UPDATED_AT = 'updated_date';
    public $timestamps = true;


    protected $fillable = [
        'type_exercise',
        'topic_exercise',
        'question',
        'explanation',
        'level',
    ];

    protected $casts = [
        'register_date' => 'datetime',
        'updated_date' => 'datetime',
    ];

    // Relación con exercises_answer
    public function answers()
    {
        return $this->hasMany(ExerciseAnswer::class, 'exercise_id', 'id_exercises');
    }
    
}
