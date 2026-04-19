<?php

namespace App\Modules\Learning\Models;

use Illuminate\Database\Eloquent\Model;

class ExerciseAnswer extends Model {

    protected $table = 'exercise_answers';
    protected $primaryKey = 'id_exercise_answers';
    protected $foreignKeyExercise = 'exercise_id';

    public $timestamps = false;


    protected $fillable = [
        'answer',
        'is_correct_answer',
        'explanation'
    ];

    protected $casts = [
        'register_date' => 'datetime',
        'updated_date' => 'datetime',
    ];

    // Relación con exercises_answer
    public function exercise()
    {
        return $this->belongsTo(Exercise::class, 'exercise_id', 'id_exercises');
    }
    
}
