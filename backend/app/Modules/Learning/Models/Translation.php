<?php

namespace App\Modules\Learning\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model {

    protected $table = 'translations';
    protected $primaryKey = 'id_translations';
    // protected $foreignKeyLanguage = 'target_language_id';
    // protected $foreignKeyWords = 'word_id';

    
    const CREATED_AT = 'register_date';
    const UPDATED_AT = 'updated_date';
    public $timestamps = true;


    protected $fillable = [
        'target_language_id',
        'translation',
        'example'
    ];

    // protected $hidden = [
    //     'password',
    // ];

    protected $casts = [
        'register_date' => 'datetime',
        'updated_date' => 'datetime',
    ];
    
}
