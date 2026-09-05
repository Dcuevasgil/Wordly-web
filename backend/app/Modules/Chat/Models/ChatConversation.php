<?php

namespace App\Modules\Chat\Models;

use App\Modules\Auth\Models\User;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatConversation extends Model {

    protected $table = 'chat_conversations';
    protected $primaryKey = 'id_chat_conversations';

    
    const CREATED_AT = 'register_date';
    const UPDATED_AT = 'updated_date';

    protected $fillable = [
        'user_id',
        'title',
        'is_active',
    ];

    protected $casts = [
        'register_date' => 'datetime',
        'updated_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Relación con users
    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id_users');
    }

    // Relación con chat_messages
    public function messages(): HasMany {
        return $this->hasMany(ChatMessage::class, 'conversation_id', 'id_chat_conversations');
    }
    
}
