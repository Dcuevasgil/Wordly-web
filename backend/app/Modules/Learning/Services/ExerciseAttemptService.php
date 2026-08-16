<?php

namespace App\Modules\Learning\Services;

use App\Modules\Learning\Models\Exercise;
use App\Modules\Learning\Models\ExerciseAttempt;

class ExerciseAttemptService {

    public function submitAnswer(array $data, int $userId): array {


        $exercise = Exercise::with('answers')->findOrFail($data['exercise_id']);

        $isCorrect = $this->checkAnswer($exercise, $data['user_responses']);

        $attempt = ExerciseAttempt::create([
            'user_id' => $userId,
            'exercise_id' => $exercise->id_exercises,
            'exercise_answer_id' => $data['exercise_answer_id'] ?? null,
            'user_response' => $data['user_responses'],
            'is_user_response_correct' => $isCorrect,
            'response_time_ms' => $data['response_time_ms'],
            'attempt_date' => now(),
        ]);

        return [
            "attempt" => $attempt,
            "exercise" => $exercise,
        ];
        
    }

    private function checkAnswer(Exercise $exercise, array $userResponses): bool {

        $correctAnswers = $exercise->answers
            ->where('is_correct_answer', true)
            ->map(fn ($answer) => $this->normalize($answer->answer))
            ->all();

        $normalized = $this->normalize($userResponses[0]);

        return in_array($normalized, $correctAnswers, true);
    }


    private function normalize(string $value): string {
        return mb_strtolower(trim($value));
    }
}