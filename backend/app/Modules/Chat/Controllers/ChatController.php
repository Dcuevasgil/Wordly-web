<?php

namespace App\Modules\Chat\Controllers;

use App\Http\Controllers\Controller;

use App\Modules\Chat\Requests\SendMessageRequest;
use App\Modules\Chat\Resources\ChatConversationResource;
use App\Modules\Chat\Resources\ChatMessageResource;
use App\Modules\Chat\Services\ChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ChatController extends Controller {

    public function __construct(private readonly ChatService $chatService) {}

    public function sendMessage(SendMessageRequest $request): JsonResponse {

        $conversationId = $request->input('conversation_id');

        $conversation = $this->chatService->sendMessage(
            userId: $request->user()->id_users,
            content: $request->input('content'),
            conversationId: $conversationId,
        );

        return response()->json([
            'conversation_id' => $conversation->id_chat_conversations,
            'title' => $conversation->title,
            'messages' => ChatMessageResource::collection($conversation->messages),
        ], $conversationId === null ? 201 : 200);
    }

    public function listConversations(Request $request): JsonResponse {

        $conversations = $this->chatService->listConversations(
            userId: $request->user()->id_users,
        );

        return ChatConversationResource::collection($conversations)->response();
    }

    public function getConversationMessages(Request $request, int $id_chat_conversations): JsonResponse {

        $messages = $this->chatService->getConversationMessages(
            userId: $request->user()->id_users,
            conversationId: $id_chat_conversations,
        );

        return ChatMessageResource::collection($messages)->response();
    }
}