<?php

namespace App\Modules\Learning\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class AssessmentRequest extends FormRequest {

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {

        $totalExercises = config('filter-quiz.assessment.total_exercises');
        
        return [
            'answers' => ['required', 'array', 'size:' . $totalExercises],

            'answers.*.exercise_id' => [
                'required', 
                'integer', 'distinct', 
                Rule::exists('exercises', 'id_exercises')
            ],

            'answers.*.exercise_answer_id' => [
                'required', 
                'integer', 
                Rule::exists('exercise_answers', 'id_exercise_answers')
            ],
        ];
    }

    public function messages(): array {
        return [
            'answers.required' => 'The answers field is required.',
            'answers.array' => 'The answers fields must be an array.',
            'answers.size' => 'The assessment must contain exactly :size answers.',

            
            'answers.*.exercise_id.required' => 'Each answer must include an exercise id.',
            'answers.*.exercise_id.distinct' => 'Duplicated exercises are not allowed.',
            'answers.*.exercise_id.exists' => 'The selected exercise does not exist.',

            'answers.*.exercise_answer_id.required' => 'Each answer must include an answer id.',
            'answers.*.exercise_answer_id.exists' => 'The selected answer does not exist.'
        ];
    }
}



