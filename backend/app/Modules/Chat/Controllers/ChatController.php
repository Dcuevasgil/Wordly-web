<?php

namespace App\Modules\Chat\Controllers;

use App\Http\Controllers\Controller;

use App\Modules\Chat\Requests\SendMessageRequest;
use App\Modules\Chat\Services\ChatService;
use Illuminate\Http\JsonResponse;


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
            'messages' => $conversation->messages,
        ], $conversationId === null ? 201 : 200);
    }
}