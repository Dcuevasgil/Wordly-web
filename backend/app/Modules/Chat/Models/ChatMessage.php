<?php

namespace App\Modules\Chat\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model {

    public const ROLE_USER = 'user';
    public const ROLE_ASSISTANT = 'assistant';


    protected $table = 'chat_messages';
    protected $primaryKey = 'id_chat_messages';


    
    const CREATED_AT = 'register_date';
    const UPDATED_AT = null;

    protected $fillable = [
        'conversation_id',
        'role',
        'content',
        'model',
        'tokens_used',
        'latency_ms',
    ];

    protected $casts = [
        'register_date' => 'datetime',
        'tokens_used' => 'integer',
        'latency_ms' => 'integer',
    ];

    // Relación con chat_conversations
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(ChatConversation::class, 'conversation_id', 'id_chat_conversations');
    }
    
}
