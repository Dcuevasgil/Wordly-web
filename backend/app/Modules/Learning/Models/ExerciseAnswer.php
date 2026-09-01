<?php

namespace App\Modules\Learning\Models;

use Illuminate\Database\Eloquent\Model;

class ExerciseAnswer extends Model {

    protected $table = 'exercise_answers';
    protected $primaryKey = 'id_exercise_answers';

    public $timestamps = false;


    protected $fillable = [
        'id_exercise_answers',
        'exercise_id',
        'answer',
        'is_correct_answer',
        'explanation'
    ];

    protected $casts = [
        'is_correct_answer' => 'boolean',
        'register_date' => 'datetime',
        'updated_date' => 'datetime',
    ];

    // Relación con exercises_answer
    public function exercise()
    {
        return $this->belongsTo(Exercise::class, 'exercise_id', 'id_exercises');
    }
    
}
