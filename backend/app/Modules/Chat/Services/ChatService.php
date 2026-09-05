<?php

namespace App\Modules\Chat\Services;

use App\Modules\Chat\Models\ChatConversation;
use App\Modules\Chat\Models\ChatMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

class ChatService {

    public function sendMessage(int $userId, string $content, ?int $conversationId = null): ChatConversation {

        return DB::transaction(function () use ($userId, $content, $conversationId) {

            $conversation = $conversationId === null ? $this->createConversation($userId, $content) : $this->resolveConversation($userId, $conversationId);

            $conversation->messages()->create([

                'role' => ChatMessage::ROLE_USER,

                'content' => $content,

            ]);

            $conversation->messages()->create([

                'role' => ChatMessage::ROLE_ASSISTANT,

                'content' => $this->generateReply($content),

            ]);

            $conversation->touch();

            return $conversation->fresh()->load('messages');
        });

    }

    private function createConversation(int $userId, string $firstMessage): ChatConversation {

        return ChatConversation::create([

            'user_id' => $userId,

            'title' => $this->buildTitle($firstMessage),

        ]);
    }

    private function resolveConversation(int $userId, int $conversationId): ChatConversation {

        return ChatConversation::where('id_chat_conversations', $conversationId)
            ->where('user_id', $userId)
            ->firstOrFail();

    }

    private function buildTitle(string $firstMessage): string {

        $maxLength = config('chat.title_max_length');

        if (!is_int($maxLength)) {
            throw new RuntimeException('Missing or invalid config value: chat.title_max_length');
        }

        return Str::limit(trim($firstMessage), $maxLength);
    }

    /**
     * Placeholder reply. Will be replaced by the AI provider call.
     */
    private function generateReply(string $userMessage): string {
        return 'Fixed assistant reply. AI provider not connected yet.';
    }

}
