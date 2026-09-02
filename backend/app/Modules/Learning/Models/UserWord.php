<?php

namespace App\Modules\Learning\Models;

use Illuminate\Database\Eloquent\Model;

class UserWord extends Model {

    protected $table = 'user_words';
    protected $primaryKey = 'id_user_words';
    protected $foreignKeyUsers = 'user_id';
    protected $foreignKeyWords = 'word_id';

    const CREATED_AT = 'register_date';
    const UPDATED_AT = 'updated_date';
    public $timestamps = true;

    protected $fillable = [
        'times_correct',
        'times_failed',
        'times_reviewed',
        'days_interval',
        'ease_factor',
        'last_review',
        'next_review',
        'mastered_level'
    ];

    protected $casts = [
        'register_date' => 'datetime',
        'update_date' => 'datetime',
    ];

    // Relaciones con tablas

    // Words
    public function word() {
        return $this->belongsTo(Word::class, 'word_id', 'id_words');
    }
    
}
