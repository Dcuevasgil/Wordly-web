<?php

namespace App\Modules\Learning\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExerciseAnswerResource extends JsonResource {

    public function toArray(Request $request): array {
        return [
            'id' => $this->id_exercise_answers,
            'answer' => $this->answer,
        ];
    }
}