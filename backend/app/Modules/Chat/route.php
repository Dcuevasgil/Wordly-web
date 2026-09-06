<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Modules\Chat\Controllers\ChatController;


Route::prefix('chat')->middleware('auth:api')->group(function () {

    Route::post('/message', [ChatController::class, 'sendMessage'])->middleware('throttle:20,1');

    Route::get('/conversations', [ChatController::class, 'listConversations']);

    Route::get('/conversations/{id_chat_conversations}/messages', [ChatController::class, 'getConversationMessages']);
});
