<?php

namespace App\Modules\Learning\Models;

use Illuminate\Database\Eloquent\Model;

use App\Modules\Auth\Models\User;
// use App\Modules\Learning\Models\Exercise;
// use App\Modules\Learning\Models\ExerciseAnswer;

class ExerciseAttempt extends Model {

    protected $table = 'exercise_attempts';
    protected $primaryKey = 'id_exercise_attempts';
    // protected $foreignKeyExercise = 'exercise_id';
    // protected $foreignKeyUsers = 'user_id';
    // protected $foreignKeyAnswer = 'exercise_answer_id';

    const CREATED_AT = 'register_date';
    const UPDATED_AT = 'updated_date';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'exercise_id',
        'exercise_answer_id',
        'is_user_response_correct',
        'user_response',
        'response_time_ms',
        'attempt_date'
    ];

    protected $casts = [
        'user_response' => 'array',
        'is_user_response_correct' => 'boolean',
        'attempt_date' => 'datetime',
        'register_date' => 'datetime',
        'updated_date' => 'datetime',
    ];


    // Relaciones con users, exercise y exerciseAnswer

    // Users
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id_users');
    }

    // Exercise
    public function exercise() {
        return $this->belongsTo(Exercise::class, 'exercise_id', 'id_exercises');
    }

    // ExerciseAnswer
    public function exerciseAnswer() {
        return $this->belongsTo(ExerciseAnswer::class, 'exercise_answer_id', 'id_exercise_answers');
    }

}