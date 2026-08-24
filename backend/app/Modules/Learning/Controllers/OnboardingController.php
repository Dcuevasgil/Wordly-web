<?php

namespace App\Modules\Learning\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Modules\Learning\Requests\OnboardingRequest;

use App\Modules\Learning\Models\LearningPath;
use App\Modules\Learning\Models\UserPath;

use RuntimeException;

class OnboardingController {

    
    public function createEnrollment(OnboardingRequest $request) {

        // 1. User Authenticated
        /** @var \App\Modules\Auth\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'error_code' => 'unauthorized',
                'error' => 'Unauthorized'
            ], 401);
        }

        
        // 2. Ask to UserPath if there is already a queue
        if ($user->paths()->exists()) {
            return response()->json([
                'error_code' => 'already_enrolled',
                'error' => 'User already has an enrollment',
            ], 409);
        }


        // 3. Solve the LearningPath
        $learningPath = LearningPath::where('code', LearningPath::DEFAULT_CODE)->first();

        if ($learningPath === null) {
            throw new RuntimeException(
                'Default learning path not found: ' . LearningPath::DEFAULT_CODE
            );
            
        }


        // 4. Create row
        $userPath = UserPath::create([
            'user_id' => $user->id_users,
            'learning_path_id' => $learningPath->id_learning_paths,
            'level' => $request->validated('level'),
            'self_assessment' => $request->validated('self_assessment'),
        ]);

        // 5. Response
        return response()->json([
            'message' => 'Enrollment created successfully',
            'data' => [
                'level' => $userPath->level,
                'self_assessment' => $userPath->self_assessment,
                'learning_path' => $learningPath->code,
            ],
        ], 201);

    }

}