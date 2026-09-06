<?php

namespace App\Modules\Chat\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Modules\Chat\Models\ChatConversation;
use App\Modules\Chat\Models\ChatMessage;
use App\Modules\Chat\Prompts\ConversationPrompt;
use App\Modules\Learning\Services\UserContextService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

class ChatService {


    public function __construct(
        private readonly OllamaClient $ollama,
        private readonly ConversationPrompt $prompt,
        private readonly UserContextService $userContext,
    ) {}


    public function sendMessage(int $userId, string $content, ?int $conversationId = null): ChatConversation {

        return DB::transaction(function () use ($userId, $content, $conversationId) {

            $conversation = $conversationId === null ? $this->createConversation($userId, $content) : $this->resolveConversation($userId, $conversationId);

            $conversation->messages()->create([
                'role' => ChatMessage::ROLE_USER,
                'content' => $content,
            ]);

            $reply = $this->generateReply($userId, $conversation);

            $conversation->messages()->create([
                'role' => ChatMessage::ROLE_ASSISTANT,
                'content' => $reply['content'],
                'model' => $reply['model'],
                'tokens_used' => $reply['tokens_used'],                
                'latency_ms' => $reply['latency_ms'],
            ]);

            $conversation->touch();

            return $conversation->fresh()->load('messages');
        });

    }

    public function listConversations(int $userId): LengthAwarePaginator {
        return ChatConversation::where('user_id', $userId)
            ->select('id_chat_conversations', 'title', 'updated_date')            
            ->orderByDesc('updated_date')
            ->paginate(config('chat.conversations_per_page'));
    }


    public function getConversationMessages(int $userId, int $conversationId): Collection {

        $conversation = $this->resolveConversation($userId, $conversationId);

        return $conversation->messages()
            ->orderBy('id_chat_messages')
            ->get();
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
     * Builds the payload for the model: system prompt with the learner's
     * level and vocabulary, followed by the recent history of the
     * conversation. History is capped at chat.history_window.
     * 
     * @return array{content: string, model: string, tokens_used: ?int, latency_ms: ?int}
     */
    private function generateReply(int $userId, ChatConversation $conversation): array {

        $systemPrompt = $this->prompt->build(
            $this->userContext->getCurrentLevel($userId),
            $this->userContext->getVocabularySample($userId, config('chat.vocabulary_window')),
        );

        $history = $conversation->messages()
            ->orderByDesc('id_chat_messages')
            ->limit(config('chat.history_window'))
            ->get()
            ->reverse()
            ->map(fn (ChatMessage $message) => [
                'role' => $message->role,
                'content' => $message->content,
            ])
            ->values()
            ->all();


        return $this->ollama->chat([
            ['role' => 'system', 'content' => $systemPrompt],
            ...$history,
        ]);
    }

}
