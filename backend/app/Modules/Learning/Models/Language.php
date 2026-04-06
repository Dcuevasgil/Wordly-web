<?php

namespace App\Modules\Learning\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model {

    protected $table = 'languages';
    protected $primaryKey = 'id_languages';
    // protected $foreignKeyLanguage = 'target_language_id';
    // protected $foreignKeyWords = 'word_id';

    
    const CREATED_AT = 'register_date';
    const UPDATED_AT = 'updated_date';
    public $timestamps = true;


    protected $fillable = [
        'name',
        'code'
    ];

    // protected $hidden = [
    //     'password',
    // ];

    protected $casts = [
        'register_date' => 'datetime',
        'updated_date' => 'datetime',
    ];
    
}
