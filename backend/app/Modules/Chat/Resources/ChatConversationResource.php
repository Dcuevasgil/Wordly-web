<?php

namespace App\Modules\Chat\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatConversationResource extends JsonResource {

    public function toArray(Request $request): array {
        return [
            'id' => $this->id_chat_conversations,
            'title' => $this->title,
            'updated_date' => $this->updated_date,
        ];
    }
}