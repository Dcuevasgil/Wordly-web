<?php

namespace App\Modules\Learning\Models;

use Illuminate\Database\Eloquent\Model;

use App\Modules\Learning\Models\Translation;

class Word extends Model {

    protected $table = 'words';
    protected $primaryKey = 'id_words';
    // protected $foreignKeyLanguage = 'origin_language_id';
    // protected $foreignKeyWords = 'word_id';

    
    const CREATED_AT = 'register_date';
    const UPDATED_AT = 'updated_date';
    public $timestamps = true;


    protected $fillable = [
        'text',
        'difficult'
    ];

    protected $casts = [
        'register_date' => 'datetime',
        'updated_date' => 'datetime',
    ];

    // Relaciones con tablas

    // Translations
    public function translations() {
        return $this->hasMany(Translation::class, 'word_id', 'id_words');
    }
    
}
