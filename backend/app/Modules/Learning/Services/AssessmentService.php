<?php

namespace App\Modules\Learning\Services;

use App\Modules\Learning\Models\ExerciseAnswer;
use App\Modules\Learning\Models\UserPath;

class AssessmentService {

    /**
     * Evaluates a submitted assessment: corrects the answers, resolves the resulting level and asssigns it to the user
     * 
     * @param array $answers [['exercise_id' => int, 'exercise_answer_id' => int], ...]
     */
    public function evaluate(int $userId, array $answers): array {

        $total = config('filter-quiz.assessment.total_exercises');

        $correct = $this->countCorrectAnswers($answers);
        $percentage = ($correct / $total) * 100;
        $level = $this->resolveLevel($percentage);

        $this->assignLevel($userId, $level);

        return [
            'correct_answers' => $correct,
            'total_exercises' => $total,
            'score_percentage' => round($percentage, 2),
            'assigned_level' => $level,
        ];
    }

    /**
     * Corrects the submitted answers against the database.
     * Returns the number of correct answers.
     * 
     * @param array $answers [['exercise_id' => int, 'exercise_answer_id' => int], ...]
     */
    public function countCorrectAnswers(array $answers): int {
        
        $answersIds = array_column($answers, 'exercise_answer_id');
        
        $rows = ExerciseAnswer::whereIn('id_exercise_answers', $answersIds)
            ->get()
            ->keyBy('id_exercise_answers');
        
        $correct = 0;

        foreach ($answers as $answer) {
            
            $row = $rows->get($answer['exercise_answer_id']);

            if ($row === null) {
                continue;
            }

            if ((int) $row->exercise_id !== (int) $answer['exercise_id']) {
                continue;
            }

            if ($row->is_correct_answer) {
                $correct++;
            }

        }

        return $correct;

    }

    /**
     * Maps a score percentage to a level code.
     * Thresholds are checked from highest to lowest.
     */
    public function resolveLevel(float $percentage): string {
        
        $thresholds = config('filter-quiz.assessment.thresholds');
        $levels = config('filter-quiz.levels');

        foreach (array_reverse($levels) as $level) {
            
            if (!isset($thresholds[$level])) {
                return $level;
            }

            if ($percentage >= $thresholds[$level]) {
                return $level;
            }

        }

    }

    /**
     * Assigns the resolved level to the user's active enrollment
     */
    private function assignLevel(int $userId, string $level): void {
        
        UserPath::where('user_id', $userId)
            ->where('is_active', true)
            ->update(['level' => $level]);
    }

}