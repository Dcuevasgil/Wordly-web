<?php

namespace App\Modules\Learning\Controllers;

use App\Http\Controllers\Controller;

use App\Modules\Learning\Models\Exercise;
use App\Modules\Learning\Models\UserPath;
use App\Modules\Learning\Requests\AssessmentRequest;
use App\Modules\Learning\Resources\ExerciseResource;
use App\Modules\Learning\Services\AssessmentService;
use Illuminate\Http\JsonResponse;
use RuntimeException;

class AssessmentController extends Controller {


    public function __construct(private AssessmentService $service) {}

    /**
     * Returns the placement exam: a fixed number of exercises per level.
     */
    public function getAssessment(): JsonResponse {

        $levels = config('filter-quiz.levels');
        $perLevel = config('filter-quiz.assessment.per_level');

        $exercises = collect();

        foreach ($levels as $level) {
            
            $levelExercises = Exercise::with('answers')
                ->where('level', $level)
                ->inRandomOrder()
                ->limit($perLevel)
                ->get();
            
            if ($levelExercises->count() < $perLevel) {
                throw new RuntimeException(
                    "Not enough exercises for level '{$level}': " . "{$levelExercises->count()} found, {$perLevel} required.");
                
            }

            $exercises = $exercises->concat($levelExercises);
        }

        return response()->json([
            'total_exercises' => $exercises->count(),
            'exercises' => ExerciseResource::collection($exercises),
        ]);
    }

    /**
     * Receives the submitted answers, resolves the level and assigns it.
     */
    public function submitAssessment(AssessmentRequest $request): JsonResponse {

        $userId = $request->user()->id_users;

        $hasEnrollment = UserPath::where('user_id', $userId)
            ->where('is_active', true)
            ->exists();
        
        if (!$hasEnrollment) {
            return response()->json([
                'error_code' => 'onboarding_required',
                'message' => 'You must complete onboarding before taking the assessment.'
            ], 403);
        }

        $result = $this->service->evaluate(
            $request->user()->id_users,
            $request->validated()['answers']
        );

        return response()->json($result);
    }
}