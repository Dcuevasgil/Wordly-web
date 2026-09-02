<?php

namespace App\Modules\Learning\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExerciseResource extends JsonResource {

    public function toArray(Request $request): array {
        return [
            'id' => $this->id_exercises,
            'code' => $this->code,
            'type_exercise' => $this->type_exercise,
            'topic_exercise' => $this->topic_exercise,
            'level' => $this->level,
            'question' => $this->question,
            'answers' => ExerciseAnswerResource::collection($this->whenLoaded('answers')),
        ];
    }
}