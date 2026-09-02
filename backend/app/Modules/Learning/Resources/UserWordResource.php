<?php

namespace App\Modules\Learning\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserWordResource extends JsonResource {

    public function toArray(Request $request): array {

        $translation = $this->word?->translations->first();

        return [
            'id_user_word' => $this->id_user_words,
            'word' => $this->word?->text,
            'translation' => $translation?->translation,
            'example' => $translation?->example,
            'next_review' => $this->next_review,
            'mastered_level' => $this->mastered_level,
        ];
    }
}